<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageGenerator;

/**
 * App\Models\Images
 *
 * @property int $id
 * @property string $filename
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelImages> $modelImages
 *
 * @method static \Database\Factories\ImagesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Images newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Images newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Images query()
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Images whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Images extends Model
{
    use HasFactory;

    const RESPONSIVE_IMAGE_WIDTHS = [
        'small' => 300,
        'medium' => 600,
        'large' => 1200,
    ];

    protected $guarded = [];

    private FilesystemAdapter $storage;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->storage = Storage::disk('uploads');
    }

    protected static function booted()
    {
        static::deleting(function (Images $image) {
            $image->modelImages()->delete();
        });
    }

    public function urls()
    {
        $urls = [
            'original' => $this->storage->url("{$this->id}/{$this->filename}"),
        ];

        foreach (self::RESPONSIVE_IMAGE_WIDTHS as $name => $value) {
            $urls[$name] = $this->storage->url("{$this->id}/{$name}/{$this->filename}");
        }

        return $urls;
    }

    public function associateFile(UploadedFile $file)
    {
        $this->storage->putFileAs((string) $this->id, $file, $file->getClientOriginalName());

        foreach (self::RESPONSIVE_IMAGE_WIDTHS as $name => $value) {
            if (! $this->storage->exists("{$this->id}/{$name}")) {
                $this->storage->makeDirectory("{$this->id}/{$name}");
            }

            ImageGenerator::make($file)
                ->widen($value)
                ->save($this->storage->path('') . "{$this->id}/{$name}/" . $file->getClientOriginalName());
        }
    }

    public function modelImages()
    {
        return $this->hasMany(ModelImages::class, 'image_id');
    }
}

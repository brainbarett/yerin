<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageGenerator;

class Images extends Model
{
    use HasFactory;

	protected $guarded = [];

	private FilesystemAdapter $storage;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->storage = Storage::disk('uploads');
    }
	
	const RESPONSIVE_IMAGE_WIDTHS = [
        'sn' => 300,
        'md' => 600,
        'lg' => 1200
    ];

	public function urls()
    {
        $urls = [
            'original' => $this->storage->url("{$this->id}/{$this->filename}")
        ];

        foreach(self::RESPONSIVE_IMAGE_WIDTHS as $name => $value) {
            $urls[$name] = $this->storage->url("{$this->id}/$name/{$this->filename}");
        }

        return $urls;
    }

	public function associateFile(UploadedFile $file)
    {
        $this->storage->putFileAs($this->id, $file, $file->getClientOriginalName());

        foreach(self::RESPONSIVE_IMAGE_WIDTHS as $name => $value) {
            if(!$this->storage->exists("{$this->id}/$name")) {
                $this->storage->makeDirectory("{$this->id}/$name");
            }
                
            ImageGenerator::make($file)
                ->widen($value)
                ->save($this->storage->path('') . "{$this->id}/$name/" . $file->getClientOriginalName());
        }
    }
}

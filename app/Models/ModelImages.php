<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModelImages
 *
 * @property int $id
 * @property int $image_id
 * @property string $imageable_type
 * @property int $imageable_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|Eloquent $imageable
 * @property-read \App\Models\Images|null $source
 *
 * @method static Builder|ModelImages newModelQuery()
 * @method static Builder|ModelImages newQuery()
 * @method static Builder|ModelImages query()
 * @method static Builder|ModelImages whereCreatedAt($value)
 * @method static Builder|ModelImages whereId($value)
 * @method static Builder|ModelImages whereImageId($value)
 * @method static Builder|ModelImages whereImageableId($value)
 * @method static Builder|ModelImages whereImageableType($value)
 * @method static Builder|ModelImages whereOrder($value)
 * @method static Builder|ModelImages whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ModelImages extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['source'];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    public function source()
    {
        return $this->hasOne(Images::class, 'id', 'image_id');
    }

    /** @return Attribute<string, never> */
    public function filename(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->source->filename
        );
    }
}

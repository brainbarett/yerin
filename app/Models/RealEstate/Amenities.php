<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RealEstate\Amenities
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\RealEstate\AmenitiesFactory factory($count = null, $state = [])
 * @method static Builder|Amenities newModelQuery()
 * @method static Builder|Amenities newQuery()
 * @method static Builder|Amenities query()
 * @method static Builder|Amenities whereCreatedAt($value)
 * @method static Builder|Amenities whereId($value)
 * @method static Builder|Amenities whereName($value)
 * @method static Builder|Amenities whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Amenities extends Model
{
    use HasFactory;

    protected $table = 'real_estate_amenities';
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name');
        });
    }
}

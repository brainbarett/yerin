<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RealEstate\PropertyAmenities
 *
 * @property int $id
 * @property int $property_id
 * @property int $amenity_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities whereAmenityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyAmenities whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PropertyAmenities extends Model
{
    use HasFactory;

    protected $table = 'real_estate_property_amenities';
    protected $guarded = [];
}

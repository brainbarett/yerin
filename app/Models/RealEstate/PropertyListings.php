<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RealEstate\PropertyListings
 *
 * @property int $id
 * @property int $property_id
 * @property string $type
 * @property int $price
 * @property string|null $term
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyListings whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PropertyListings extends Model
{
    use HasFactory;

    protected $table = 'real_estate_property_listings';
    protected $guarded = [];
}

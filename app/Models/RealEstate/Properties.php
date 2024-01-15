<?php

namespace App\Models\RealEstate;

use App\Models\GeoLocation\Sectors;
use App\Utils\ModelImages\HasImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RealEstate\Properties
 *
 * @property int $id
 * @property string $type
 * @property string $reference
 * @property string $name
 * @property string|null $description
 * @property int $available
 * @property int|null $bedrooms
 * @property int|null $full_bathrooms
 * @property int|null $half_bathrooms
 * @property int|null $lot_area
 * @property int|null $construction_area
 * @property string|null $construction_year
 * @property int $location_id
 * @property string|null $latitude
 * @property string|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealEstate\Amenities> $amenities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealEstate\PropertyAmenities> $amenitiesPivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModelImages> $images
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealEstate\PropertyListings> $listings
 * @property-read Sectors|null $location
 *
 * @method static \Database\Factories\RealEstate\PropertiesFactory factory($count = null, $state = [])
 * @method static Builder|Properties newModelQuery()
 * @method static Builder|Properties newQuery()
 * @method static Builder|Properties query()
 * @method static Builder|Properties search(string $string)
 * @method static Builder|Properties whereAvailable($value)
 * @method static Builder|Properties whereBedrooms($value)
 * @method static Builder|Properties whereConstructionArea($value)
 * @method static Builder|Properties whereConstructionYear($value)
 * @method static Builder|Properties whereCreatedAt($value)
 * @method static Builder|Properties whereDescription($value)
 * @method static Builder|Properties whereFullBathrooms($value)
 * @method static Builder|Properties whereHalfBathrooms($value)
 * @method static Builder|Properties whereId($value)
 * @method static Builder|Properties whereLatitude($value)
 * @method static Builder|Properties whereLocationId($value)
 * @method static Builder|Properties whereLongitude($value)
 * @method static Builder|Properties whereLotArea($value)
 * @method static Builder|Properties whereName($value)
 * @method static Builder|Properties whereReference($value)
 * @method static Builder|Properties whereType($value)
 * @method static Builder|Properties whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Properties extends Model
{
    use HasFactory, HasImages;

    protected $table = 'real_estate_properties';
    protected $guarded = [];

    public function listings()
    {
        return $this->hasMany(PropertyListings::class, 'property_id');
    }

    public function amenities()
    {
        return $this->hasManyThrough(
            Amenities::class,
            PropertyAmenities::class,
            'property_id',
            'id',
            'id',
            'amenity_id'
        );
    }

    public function amenitiesPivot()
    {
        return $this->hasMany(PropertyAmenities::class, 'property_id');
    }

    public function syncListings(array $listings)
    {
        $this->listings()->whereNotIn('type', array_keys($listings))->delete();

        foreach ($listings as $listingType => $priceOrTerms) {
            if ($listingType == 'SALE') {
                $this->listings()->updateOrCreate(
                    ['type' => $listingType],
                    ['price' => $priceOrTerms]
                );
            }

            if ($listingType == 'RENT') {
                $this->listings()->whereNotIn('term', array_keys($priceOrTerms))->delete();

                foreach ($priceOrTerms as $term => $price) {
                    $this->listings()->updateOrCreate(
                        ['type' => $listingType, 'term' => $term],
                        ['price' => $price]
                    );
                }
            }
        }
    }

    public function syncAmenities(array $amenityIds)
    {
        $this->amenitiesPivot()->whereNotIn('amenity_id', $amenityIds)->delete();

        $timestamp = now();
        $dataToInsert = collect($amenityIds)
            ->diff($this->amenitiesPivot()->pluck('amenity_id'))
            ->map(function ($amenityId) use ($timestamp) {
                return [
                    'amenity_id' => $amenityId,
                    'property_id' => $this->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            })
            ->toArray();

        $this->amenitiesPivot()->insert($dataToInsert);
    }

    public function scopeSearch(Builder $query, string $string)
    {
        return $query
            ->where('name', 'LIKE', "%{$string}%")
            ->orWhere('reference', 'LIKE', "%{$string}%");
    }

    public function location()
    {
        return $this->hasOne(Sectors::class, 'id', 'location_id');
    }
}

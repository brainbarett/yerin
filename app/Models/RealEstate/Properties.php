<?php

namespace App\Models\RealEstate;

use App\Models\GeoLocation\Sectors;
use App\Utils\ModelImages\HasImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

		foreach($listings as $listingType => $priceOrTerms) {
			if($listingType == 'SALE') {
				$this->listings()->updateOrCreate(
					['type' => $listingType],
					['price' => $priceOrTerms]
				);
			}

			if($listingType == 'RENT') {
				$this->listings()->whereNotIn('term', array_keys($priceOrTerms))->delete();

				foreach($priceOrTerms as $term => $price) {
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
			->map(function($amenityId) use($timestamp) {
				return [
					'amenity_id' => $amenityId,
					'property_id' => $this->id,
					'created_at' => $timestamp,
					'updated_at' => $timestamp
				];
			})
			->toArray();

		$this->amenitiesPivot()->insert($dataToInsert);
	}

	public function scopeSearch(Builder $query, string $string)
	{
		return $query
			->where('name', 'LIKE', "%$string%")
			->orWhere('reference', 'LIKE', "%$string%");
	}

	public function location()
	{
		return $this->hasOne(Sectors::class, 'id', 'location_id');
	}
}

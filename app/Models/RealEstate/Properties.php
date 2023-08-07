<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;

	protected $table = 'real_estate_properties';
	protected $guarded = [];

	public function listings()
	{
		return $this->hasMany(PropertyListings::class, 'property_id');
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
}

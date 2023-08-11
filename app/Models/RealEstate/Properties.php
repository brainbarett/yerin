<?php

namespace App\Models\RealEstate;

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

	public function scopeSearch(Builder $query, string $string)
	{
		return $query
			->where('name', 'LIKE', "%$string%")
			->orWhere('reference', 'LIKE', "%$string%");
	}
}

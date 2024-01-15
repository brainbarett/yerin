<?php

namespace App\Http\Resources\Api\Admin\RealEstate;

use App\Enums\RealEstate\RentTerms;
use App\Http\Resources\Api\Admin\ModelImagesResource;
use App\Models\RealEstate\Properties;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin Properties */
class PropertiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'reference' => $this->reference,
            'name' => $this->name,
            'description' => $this->description,
            'available' => (bool) $this->available,

            'bedrooms' => $this->bedrooms,
            'full_bathrooms' => $this->full_bathrooms,
            'half_bathrooms' => $this->half_bathrooms,

            'lot_area' => $this->lot_area,
            'construction_area' => $this->construction_area,

            'construction_year' => $this->construction_year,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => [
                'sector_id' => $this->location->id,
                'city_id' => $this->location->city_id,
                'state_id' => $this->location->state_id,
                'country_id' => $this->location->country_id,
            ],

            'amenities' => AmenitiesResource::collection($this->amenities)->resolve(),

            'listings' => [
                'SALE' => $this->listings->firstWhere('type', 'SALE')?->price,
                'RENT' => collect(RentTerms::names())
                    ->flatMap(function ($term) {
                        return [$term => $this->listings->firstWhere('term', $term)?->price];
                    })
                    ->toArray(),
            ],

            'images' => ModelImagesResource::collection($this->images)->resolve(),
        ];
    }
}

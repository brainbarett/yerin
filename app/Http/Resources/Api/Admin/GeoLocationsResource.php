<?php

namespace App\Http\Resources\Api\Admin;

use App\Models\GeoLocation\Cities;
use App\Models\GeoLocation\Sectors;
use App\Models\GeoLocation\States;
use Illuminate\Http\Resources\Json\JsonResource;

class GeoLocationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
			'id' => $this->id,
			'name' => $this->name,
			'states' => $this->states->map(function(States $state) {
				return [
					'id' => $state->id,
					'name' => $state->name,
					'cities' => $state->cities->map(function(Cities $city) {
						return [
							'id' => $city->id,
							'name' => $city->name,
							'sectors' => $city->sectors->map(function(Sectors $sector) {
								return [
									'id' => $sector->id,
									'name' => $sector->name
								];
							})->toArray()
						];
					})->toArray()
				];
			})->toArray()
		];
    }
}

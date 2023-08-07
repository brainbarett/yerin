<?php

namespace App\Http\Resources\Api\Admin\RealEstate;

use App\Http\Resources\Api\Admin\ImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertiesResource extends JsonResource
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
			'type' => $this->type,
			'reference' => $this->reference,
			'name' => $this->name,
			'description' => $this->description,

			'maintenance_fee' => $this->maintenance_fee,
			'parking_spaces' => $this->parking_spaces,
			'financing' => (bool)$this->financing,
			'available' => (bool)$this->available,

			'bedrooms' => $this->bedrooms,
			'full_bathrooms' => $this->full_bathrooms,
			'half_bathrooms' => $this->half_bathrooms,

			'lot_area' => $this->lot_area,
			'construction_area' => $this->construction_area,

			'construction_date' => $this->construction_date,
			'created_at' => (string)$this->created_at,
			'updated_at' => (string)$this->updated_at,
			
			'images' => ImagesResource::collection($this->images->map->source)->resolve(),
		];
    }
}

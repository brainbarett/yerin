<?php

namespace App\Http\Resources\Api\Admin\RealEstate;

use App\Models\RealEstate\Amenities;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin Amenities */
class AmenitiesResource extends JsonResource
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
            'name' => $this->name,
        ];
    }
}

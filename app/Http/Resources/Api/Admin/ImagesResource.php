<?php

namespace App\Http\Resources\Api\Admin;

use App\Models\Images;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin Images */
class ImagesResource extends JsonResource
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
            'filename' => $this->filename,
            'sizes' => $this->urls(),
        ];
    }
}

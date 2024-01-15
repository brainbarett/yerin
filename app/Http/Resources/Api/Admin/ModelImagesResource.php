<?php

namespace App\Http\Resources\Api\Admin;

use App\Models\ModelImages;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin ModelImages */
class ModelImagesResource extends JsonResource
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
            'id' => $this->image_id,
            'sizes' => $this->source->urls(),
            'filename' => $this->filename,
            'order' => $this->order,
        ];
    }
}

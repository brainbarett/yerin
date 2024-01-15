<?php

namespace App\Http\Resources\Api\Admin;

use App\Models\Users;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin Users */
class UsersResource extends JsonResource
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
            'email' => $this->email,
            'language' => $this->language,
            'role' => RolesResource::make($this->roles->first())->resolve(),
        ];
    }
}

<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
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
			'permissions' => $this->permissions->map(function($permission) {
				return [
					'id' => $permission->id,
					'name' => $permission->name
				];
			})->toArray()
		];
    }
}

<?php

namespace App\Http\Resources\Api\Admin;

use App\Models\Roles;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/** @mixin Roles */
class RolesResource extends JsonResource
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
            'super_admin' => (bool) $this->super_admin,
            'system_role' => (bool) $this->system_role,
            'permissions' => $this->permissions->pluck('name')->toArray(),
        ];
    }
}

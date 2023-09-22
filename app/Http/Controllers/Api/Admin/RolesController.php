<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Roles\IndexRequest;
use App\Http\Requests\Api\Admin\Roles\StoreRequest;
use App\Http\Resources\Api\Admin\RolesResource;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
	public function index(IndexRequest $request)
    {
        return RolesResource::collection(Roles::all());
    }
	
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $role = DB::transaction(function() use($data) {
            $role = Roles::create(['name' => $data['name']]);

            $role->syncPermissions($data['permissions']);

            return $role;
        });

        return RolesResource::make($role);
    }
}

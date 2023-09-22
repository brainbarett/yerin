<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Roles\StoreRequest;
use App\Http\Resources\Api\Admin\RolesResource;
use App\Models\Roles;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
	public function __construct()
    {
		$this->middleware(function ($request, $next) {
			if($request->user()->roles()->where('super_admin', true)->doesntExist()) {
				throw new AuthorizationException;
			}

			return $next($request);
		});
	}

	public function index()
    {
        return RolesResource::collection(Roles::all());
    }

	public function show(Roles $role)
    {
        return RolesResource::make($role);
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

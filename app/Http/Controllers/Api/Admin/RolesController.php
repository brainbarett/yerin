<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Roles\StoreRequest;
use App\Http\Requests\Api\Admin\Roles\UpdateRequest;
use App\Http\Resources\Api\Admin\RolesResource;
use App\Models\Roles;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->user()->roles()->where('super_admin', true)->doesntExist()) {
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

        $role = $this->upstore($data);

        return RolesResource::make($role);
    }

    public function update(UpdateRequest $request, Roles $role)
    {
        $data = $request->validated();

        $this->upstore($data, $role);

        return response()->json([], 204);
    }

    public function destroy(Roles $role)
    {
        abort_if((bool) $role->system_role, 403, __('cant-delete-system-role'));

        $role->delete();

        return response()->json([], 204);
    }

    private function upstore(array $data, ?Roles $role = null): Roles
    {
        if (is_null($role)) {
            $role = new Roles;
        }

        return DB::transaction(function () use ($data, $role) {
            $role->fill(Arr::except($data, 'permissions'))->save();

            if (! $role->super_admin) {
                $role->syncPermissions($data['permissions']);
            }

            return $role;
        });
    }
}

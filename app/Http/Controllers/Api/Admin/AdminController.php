<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Admin\DestroyRequest;
use App\Http\Requests\Api\Admin\Admin\PatchRequest;
use App\Http\Requests\Api\Admin\Admin\StoreRequest;
use App\Http\Requests\Api\Admin\Admin\UpdateRequest;
use App\Http\Resources\Api\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	public function index()
    {
        return AdminResource::collection(Admin::all());
    }

	public function show(Admin $admin)
    {
        return AdminResource::make($admin);
    }

    public function store(StoreRequest $request)
    {
		$admin = $this->upstore($request->validated());

        return AdminResource::make($admin);
    }

    public function update(UpdateRequest $request, Admin $admin)
    {
		$admin = $this->upstore($request->validated(), $admin);

        return AdminResource::make($admin);
    }

	public function patch(PatchRequest $request, Admin $admin)
	{
		$admin->update($request->validated());

		return AdminResource::make($admin->refresh());
	}

	public function destroy(DestroyRequest $request, Admin $admin)
    {
        $admin->delete();

        return response()->json([], 204);
    }

	private function upstore(array $data, Admin $admin = null): Admin
	{
		if(is_null($admin)) {
			$admin = new Admin();
		}

		return DB::transaction(function() use($data, $admin) {
			$admin->fill(Arr::except($data, 'role'))->save();
            $admin->syncRoles($data['role']);

            return $admin;
        });
	}
}

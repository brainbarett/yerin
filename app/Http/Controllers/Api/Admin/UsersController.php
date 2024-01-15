<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Users\DestroyRequest;
use App\Http\Requests\Api\Admin\Users\PatchRequest;
use App\Http\Requests\Api\Admin\Users\StoreRequest;
use App\Http\Requests\Api\Admin\Users\UpdateRequest;
use App\Http\Resources\Api\Admin\UsersResource;
use App\Models\Users;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        return UsersResource::collection(Users::all());
    }

    public function show(Users $user)
    {
        return UsersResource::make($user);
    }

    public function store(StoreRequest $request)
    {
        $user = $this->upstore($request->validated());

        return UsersResource::make($user);
    }

    public function update(UpdateRequest $request, Users $user)
    {
        $user = $this->upstore($request->validated(), $user);

        return UsersResource::make($user);
    }

    public function patch(PatchRequest $request, Users $user)
    {
        $user->update($request->validated());

        return UsersResource::make($user->refresh());
    }

    public function destroy(DestroyRequest $request, Users $user)
    {
        $user->delete();

        return response()->json([], 204);
    }

    private function upstore(array $data, ?Users $user = null): Users
    {
        if (is_null($user)) {
            $user = new Users;
        }

        return DB::transaction(function () use ($data, $user) {
            $user->fill(Arr::except($data, 'role'))->save();

            if (isset($data['role'])) {
                $user->syncRoles($data['role']);
            }

            return $user;
        });
    }
}

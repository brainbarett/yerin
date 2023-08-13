<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Auth\LoginRequest;
use App\Http\Resources\Api\Admin\AdminResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

		abort_unless(auth('admin')->attempt($credentials), 400, __('auth.failed'));

		return AdminResource::make(auth('admin')->user());
    }

	public function isAuthenticated()
    {
        return AdminResource::make(auth('admin')->user());
    }

	public function logout()
    {
        auth('admin')->logout();

        return response()->json([], 204);
    }
}

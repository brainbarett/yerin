<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Admin\StoreRequest;
use App\Http\Resources\Api\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

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
		$admin = Admin::create($request->validated());

        return AdminResource::make($admin);
    }
}

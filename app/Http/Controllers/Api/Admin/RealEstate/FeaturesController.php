<?php

namespace App\Http\Controllers\Api\Admin\RealEstate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RealEstate\Features\DestroyRequest;
use App\Http\Requests\Api\Admin\RealEstate\Features\IndexRequest;
use App\Http\Requests\Api\Admin\RealEstate\Features\StoreRequest;
use App\Http\Requests\Api\Admin\RealEstate\Features\UpdateRequest;
use App\Http\Resources\Api\Admin\RealEstate\FeaturesResource;
use App\Models\RealEstate\Features;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    public function index(IndexRequest $request)
	{
		return FeaturesResource::collection(Features::all());
	}

	public function store(StoreRequest $request)
	{
		$feature = Features::create($request->validated());

		return FeaturesResource::make($feature);
	}

	public function update(UpdateRequest $request, Features $feature)
	{
		$feature->update($request->validated());

		return FeaturesResource::make($feature);
	}

	public function destroy(DestroyRequest $request, Features $feature)
	{
		$feature->delete();

		return response()->json([], 204);
	}
}

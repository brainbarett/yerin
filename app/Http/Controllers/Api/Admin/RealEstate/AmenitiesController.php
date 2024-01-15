<?php

namespace App\Http\Controllers\Api\Admin\RealEstate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RealEstate\Amenities\DestroyRequest;
use App\Http\Requests\Api\Admin\RealEstate\Amenities\IndexRequest;
use App\Http\Requests\Api\Admin\RealEstate\Amenities\StoreRequest;
use App\Http\Requests\Api\Admin\RealEstate\Amenities\UpdateRequest;
use App\Http\Resources\Api\Admin\RealEstate\AmenitiesResource;
use App\Models\RealEstate\Amenities;

class AmenitiesController extends Controller
{
    public function index(IndexRequest $request)
    {
        return AmenitiesResource::collection(Amenities::all());
    }

    public function store(StoreRequest $request)
    {
        $amenity = Amenities::create($request->validated());

        return AmenitiesResource::make($amenity);
    }

    public function update(UpdateRequest $request, Amenities $amenity)
    {
        $amenity->update($request->validated());

        return AmenitiesResource::make($amenity);
    }

    public function destroy(DestroyRequest $request, Amenities $amenity)
    {
        $amenity->delete();

        return response()->json([], 204);
    }
}

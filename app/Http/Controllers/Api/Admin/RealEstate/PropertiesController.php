<?php

namespace App\Http\Controllers\Api\Admin\RealEstate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RealEstate\Properties\DestroyRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\IndexRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\ShowRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\StoreRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\UpdateRequest;
use App\Http\Resources\Api\Admin\RealEstate\PropertiesResource;
use App\Models\RealEstate\Properties;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $properties = Properties::with(['listings', 'images', 'location', 'amenities'])
            ->when(isset($data['search']) && ! is_null($data['search']), function (Builder $query) use ($data) {
                return $query->search($data['search']);
            })
            ->orderByDesc('updated_at');

        return PropertiesResource::collection(
            $data['paginate']
                ? $properties->paginate($data['per_page'] ?? 25)
                : $properties->get()
        );
    }

    public function show(ShowRequest $request, Properties $property)
    {
        return PropertiesResource::make($property);
    }

    public function store(StoreRequest $request)
    {
        $property = $this->upstore($request->validated());

        return PropertiesResource::make($property);
    }

    public function update(UpdateRequest $request, Properties $property)
    {
        $property = $this->upstore($request->validated(), $property);

        return PropertiesResource::make($property);
    }

    public function destroy(DestroyRequest $request, Properties $property)
    {
        $property->delete();

        return response()->json([], 204);
    }

    private function upstore(array $data, ?Properties $property = null): Properties
    {
        if (is_null($property)) {
            $property = new Properties;
        }

        return DB::transaction(function () use ($data, $property) {
            $property->fill(Arr::except($data, ['listings', 'images', 'amenities']))->save();

            $property->syncListings($data['listings'] ?? []);
            $property->syncImages($data['images']);
            $property->syncAmenities($data['amenities']);

            return $property;
        });
    }
}

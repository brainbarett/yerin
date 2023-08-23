<?php

namespace App\Http\Controllers\Api\Admin\RealEstate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RealEstate\Properties\IndexRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\StoreRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\UpdateRequest;
use App\Http\Resources\Api\Admin\RealEstate\PropertiesResource;
use App\Models\RealEstate\Properties;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
	public function index(IndexRequest $request)
    {
		$data = $request->validated();

		$properties = Properties::with(['listings', 'images', 'location', 'features'])
			->when(isset($data['search']) && !is_null($data['search']), function(Builder $query) use($data) {
				return $query->search($data['search']);
			})
			->orderByDesc('updated_at');

		return PropertiesResource::collection(
            $data['paginate']
                ? $properties->paginate($data['per_page'] ?? 25)
                : $properties->get()
        );
    }

	public function show(Properties $property)
    {
        return PropertiesResource::make($property);
    }

    public function store(StoreRequest $request)
    {
		$data = $request->validated();

		$property = DB::transaction(function() use($data) {
			$property = Properties::create(Arr::except($data, ['listings', 'images', 'features']));

			if($data['listings']) {
				$property->syncListings($data['listings']);
			}

			$property->syncImages($data['images']);
			$property->syncFeatures($data['features']);

			return $property;
		});

        return PropertiesResource::make($property);
    }

	public function update(UpdateRequest $request, Properties $property)
	{
		$data = $request->validated();

		DB::transaction(function() use($property, $data) {
			$property->update(Arr::except($data, ['listings', 'images', 'features']));
			$property->syncListings($data['listings'] ?? []);
			$property->syncImages($data['images']);
			$property->syncFeatures($data['features']);
		});

		return PropertiesResource::make($property->refresh());
	}

	public function destroy(Properties $property)
    {
        $property->delete();

        return response()->json([], 204);
    }
}

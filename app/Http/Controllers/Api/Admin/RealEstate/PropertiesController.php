<?php

namespace App\Http\Controllers\Api\Admin\RealEstate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RealEstate\Properties\IndexRequest;
use App\Http\Requests\Api\Admin\RealEstate\Properties\StoreRequest;
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

		$properties = Properties::with(['listings', 'images'])
			->when(isset($data['search']) && !is_null($data['search']), function(Builder $query) use($data) {
				return $query->search($data['search']);
			});

		return PropertiesResource::collection(
            $data['paginate']
                ? $properties->paginate($data['per_page'] ?? 25)
                : $properties->get()
        );
    }

    public function store(StoreRequest $request)
    {
		$data = $request->validated();

		$property = DB::transaction(function() use($data) {
			$property = Properties::create(Arr::except($data, ['listings', 'images']));

			if(isset($data['listings']) && $data['listings']) {
				$property->syncListings($data['listings']);
			}

			if(isset($data['images']) && $data['images']) {
				$property->syncImages($data['images']);
			}

			return $property;
		});

        return PropertiesResource::make($property);
    }
}

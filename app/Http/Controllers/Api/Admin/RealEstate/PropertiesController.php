<?php

namespace App\Http\Controllers\Api\Admin\RealEstate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\RealEstate\Properties\StoreRequest;
use App\Http\Resources\Api\Admin\RealEstate\PropertiesResource;
use App\Models\RealEstate\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
    public function store(StoreRequest $request)
    {
		$data = $request->validated();

		$property = DB::transaction(function() use($data) {
			$property = Properties::create(Arr::except($data, 'listings'));

			if(isset($data['listings'])) {
				$property->syncListings($data['listings']);
			}

			return $property;
		});

        return PropertiesResource::make($property);
    }
}

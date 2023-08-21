<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\GeoLocationsResource;
use App\Models\GeoLocation\Countries;
use App\Models\GeoLocation\Sectors;
use Illuminate\Http\Request;

class GeoLocationsController extends Controller
{
    public function index()
	{
		return GeoLocationsResource::collection(
			Countries::with('states', 'states.cities', 'states.cities.sectors')->get()
		);
	}
}

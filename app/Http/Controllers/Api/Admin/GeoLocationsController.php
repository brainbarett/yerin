<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeoLocation\Cities;
use App\Models\GeoLocation\Countries;
use App\Models\GeoLocation\Sectors;
use App\Models\GeoLocation\States;

class GeoLocationsController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'countries' => Countries::all(),
                'cities' => Cities::all(),
                'states' => States::all(),
                'sectors' => Sectors::all(),
            ],
        ]);
    }
}

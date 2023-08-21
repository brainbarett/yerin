<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectors extends Model
{
    use HasFactory;

	protected $table = 'location_sectors';
	protected $guarded = [];

	public function country()
	{
		return $this->belongsTo(Countries::class, 'country_id');
	}

	public function state()
	{
		return $this->belongsTo(States::class, 'state_id');
	}

	public function city()
	{
		return $this->belongsTo(Cities::class, 'city_id');
	}
}

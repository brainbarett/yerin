<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

	protected $table = 'location_countries';
	protected $guarded = [];

	public function states()
	{
		return $this->hasMany(States::class, 'country_id');
	}
}

<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

	protected $table = 'location_cities';
	protected $guarded = [];

	public function sectors()
	{
		return $this->hasMany(Sectors::class, 'city_id');
	}
}

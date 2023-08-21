<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;

	protected $table = 'location_states';
	protected $guarded = [];

	public function cities()
	{
		return $this->hasMany(Cities::class, 'state_id');
	}
}

<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyListings extends Model
{
    use HasFactory;

	protected $table = 'real_estate_property_listings';
	protected $guarded = [];
}

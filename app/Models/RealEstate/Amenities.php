<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use HasFactory;

	protected $table = 'real_estate_amenities';
	protected $guarded = [];

	protected static function booted()
    {
        static::addGlobalScope('order', function(Builder $builder) {
            $builder->orderBy('name');
        });
    }
}

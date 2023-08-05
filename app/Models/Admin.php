<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;

	protected $table = 'admin';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

	protected function password(): Attribute
	{
		return Attribute::make(
			set: fn(string $password) => Hash::make($password)
		);
	}

	protected static function booted()
    {
        static::addGlobalScope('order', function(Builder $builder) {
            $builder->orderBy('name');
        });
    }
}

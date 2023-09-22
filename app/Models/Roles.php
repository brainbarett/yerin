<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRoles;

class Roles extends SpatieRoles
{
    use HasFactory;

	protected $with = ['permissions'];

	protected static function booted()
	{
		static::saving(function(Roles $role) {
			if($role->default) {
				Roles::where('default', true)
					->where('id', '!=', $role->id)
					->update(['default' => 0]);
			}
		});
	}
}

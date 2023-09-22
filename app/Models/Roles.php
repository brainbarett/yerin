<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRoles;

class Roles extends SpatieRoles
{
    use HasFactory;
}

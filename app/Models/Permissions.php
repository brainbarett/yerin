<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermissions;

class Permissions extends SpatiePermissions
{
    use HasFactory;
}

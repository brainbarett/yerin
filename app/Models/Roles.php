<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRoles;

/**
 * App\Models\Roles
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property int $system_role
 * @property int $super_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permissions> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Users> $users
 *
 * @method static \Database\Factories\RolesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Roles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles query()
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereSuperAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereSystemRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Roles whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Roles extends SpatieRoles
{
    use HasFactory;

    protected $with = ['permissions'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermissions;

/**
 * App\Models\Permissions
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permissions> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Roles> $roles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Users> $users
 *
 * @method static \Database\Factories\PermissionsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permissions whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Permissions extends SpatiePermissions
{
    use HasFactory;
}

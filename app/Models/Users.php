<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Users
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $language
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permissions> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Roles> $roles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 *
 * @method static \Database\Factories\UsersFactory factory($count = null, $state = [])
 * @method static Builder|Users newModelQuery()
 * @method static Builder|Users newQuery()
 * @method static Builder|Users permission($permissions)
 * @method static Builder|Users query()
 * @method static Builder|Users role($roles, $guard = null)
 * @method static Builder|Users whereCreatedAt($value)
 * @method static Builder|Users whereEmail($value)
 * @method static Builder|Users whereId($value)
 * @method static Builder|Users whereLanguage($value)
 * @method static Builder|Users whereName($value)
 * @method static Builder|Users wherePassword($value)
 * @method static Builder|Users whereRememberToken($value)
 * @method static Builder|Users whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles;

    protected $table = 'users';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['roles'];

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name');
        });
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $password) => Hash::make($password)
        );
    }
}

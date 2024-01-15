<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeoLocation\Countries
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GeoLocation\States> $states
 *
 * @method static \Database\Factories\GeoLocation\CountriesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Countries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Countries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Countries query()
 * @method static \Illuminate\Database\Eloquent\Builder|Countries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Countries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Countries whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Countries whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Countries extends Model
{
    use HasFactory;

    protected $table = 'location_countries';
    protected $guarded = [];

    public function states()
    {
        return $this->hasMany(States::class, 'country_id');
    }
}

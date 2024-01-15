<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeoLocation\Cities
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $state_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GeoLocation\Sectors> $sectors
 *
 * @method static \Database\Factories\GeoLocation\CitiesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cities query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cities whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cities whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cities whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cities whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Cities extends Model
{
    use HasFactory;

    protected $table = 'location_cities';
    protected $guarded = [];

    public function sectors()
    {
        return $this->hasMany(Sectors::class, 'city_id');
    }
}

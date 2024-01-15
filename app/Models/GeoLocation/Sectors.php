<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeoLocation\Sectors
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GeoLocation\Cities $city
 * @property-read \App\Models\GeoLocation\Countries $country
 * @property-read \App\Models\GeoLocation\States $state
 *
 * @method static \Database\Factories\GeoLocation\SectorsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sectors whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Sectors extends Model
{
    use HasFactory;

    protected $table = 'location_sectors';
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
}

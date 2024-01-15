<?php

namespace App\Models\GeoLocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeoLocation\States
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GeoLocation\Cities> $cities
 *
 * @method static \Database\Factories\GeoLocation\StatesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|States newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|States newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|States query()
 * @method static \Illuminate\Database\Eloquent\Builder|States whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|States whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class States extends Model
{
    use HasFactory;

    protected $table = 'location_states';
    protected $guarded = [];

    public function cities()
    {
        return $this->hasMany(Cities::class, 'state_id');
    }
}

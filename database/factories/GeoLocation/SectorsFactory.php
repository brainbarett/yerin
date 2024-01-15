<?php

namespace Database\Factories\GeoLocation;

use App\Models\GeoLocation\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeoLocation\Sectors>
 */
class SectorsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $city = Cities::factory()->create();

        return [
            'name' => $this->faker->sentence(),
            'country_id' => $city->country_id,
            'state_id' => $city->state_id,
            'city_id' => $city->id,
        ];
    }
}

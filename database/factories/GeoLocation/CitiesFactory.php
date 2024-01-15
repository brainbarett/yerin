<?php

namespace Database\Factories\GeoLocation;

use App\Models\GeoLocation\States;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeoLocation\Cities>
 */
class CitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $state = States::factory()->create();

        return [
            'name' => $this->faker->sentence(),
            'country_id' => $state->country_id,
            'state_id' => $state->id,
        ];
    }
}

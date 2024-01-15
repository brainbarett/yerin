<?php

namespace Database\Factories\GeoLocation;

use App\Models\GeoLocation\Countries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeoLocation\States>
 */
class StatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'country_id' => Countries::factory()->create()->id,
        ];
    }
}

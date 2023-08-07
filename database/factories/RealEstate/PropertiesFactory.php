<?php

namespace Database\Factories\RealEstate;

use App\Enums\RealEstate\PropertyTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RealEstate\Properties>
 */
class PropertiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(PropertyTypes::names()),
			'reference' => $this->faker->word(),
			'name' => $this->faker->sentence(),
			'available' => $this->faker->boolean(),
			'maintenance_fee' => $this->faker->randomNumber(3),
			'parking_spaces' => $this->faker->randomNumber(),
			'financing' => $this->faker->boolean(),
			'bedrooms' => $this->faker->randomNumber(),
			'full_bathrooms' => $this->faker->randomNumber(),
			'half_bathrooms' => $this->faker->randomNumber(),
			'lot_area' => $this->faker->randomNumber(3),
			'construction_area' => $this->faker->randomNumber(3),
			'construction_date' => $this->faker->date(),
        ];
    }
}

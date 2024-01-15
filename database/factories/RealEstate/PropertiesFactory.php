<?php

namespace Database\Factories\RealEstate;

use App\Enums\RealEstate\PropertyTypes;
use App\Enums\RealEstate\RentTerms;
use App\Models\GeoLocation\Sectors;
use App\Models\Images;
use App\Models\RealEstate\Properties;
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
            'reference' => $this->faker->unique()->word(),
            'name' => $this->faker->sentence(),
            'available' => $this->faker->boolean(),
            'bedrooms' => $this->faker->randomNumber(),
            'full_bathrooms' => $this->faker->randomNumber(),
            'half_bathrooms' => $this->faker->randomNumber(),
            'lot_area' => $this->faker->randomNumber(3),
            'construction_area' => $this->faker->randomNumber(3),
            'construction_year' => $this->faker->year(),
            'location_id' => Sectors::factory()->create()->id,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }

    public function withImages()
    {
        return $this->afterCreating(function (Properties $property) {
            $property->syncImages(Images::factory(3)->create());
        });
    }

    public function withListings()
    {
        return $this->afterCreating(function (Properties $property) {
            $property->syncListings([
                'SALE' => $this->faker->randomNumber(),
                'RENT' => collect(RentTerms::names())
                    ->flatMap(function ($term) {
                        return [$term => $this->faker->randomNumber()];
                    })
                    ->toArray(),
            ]);
        });
    }
}

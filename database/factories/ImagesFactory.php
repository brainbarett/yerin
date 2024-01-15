<?php

namespace Database\Factories;

use App\Models\Images;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Images>
 */
class ImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'filename' => "{$this->faker->unique()->uuid}.jpg",
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Images $image) {
            $image->associateFile(UploadedFile::fake()->image($image->filename));
        });
    }
}

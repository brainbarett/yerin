<?php

namespace Database\Factories;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roles>
 */
class RolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Roles $role) {
            $role->givePermissionTo(Permissions::factory()->create());
        });
    }
}

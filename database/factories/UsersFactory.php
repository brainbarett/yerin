<?php

namespace Database\Factories;

use App\Models\Roles;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->unique()->word,
            'language' => 'en',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Users $user) {
            $user->syncRoles(Roles::factory()->create());
        });
    }

    public function asSuperAdmin()
    {
        return $this->afterCreating(function (Users $user) {
            $user->syncRoles(Roles::where('super_admin', true)->firstOrFail());
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
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
			'language' => 'en'
        ];
    }

	public function configure()
    {
        return $this->afterCreating(function(Admin $admin) {
			$admin->syncRoles(Roles::factory()->create());
        });
    }

	public function asSuperAdmin()
    {
        return $this->afterCreating(function(Admin $admin) {
            $admin->syncRoles(Roles::where('super_admin', true)->firstOrFail());
        });
    }
}

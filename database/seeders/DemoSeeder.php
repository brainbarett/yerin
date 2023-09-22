<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
			'email' => 'admin@test.com',
			'password' => 'password',
			'language' => 'en',
			'name' => 'Test Admin'
		]);

		$this->call([
			DatabaseSeeder::class,
		]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		DB::transaction(function () {
			$admin = Admin::create([
				'email' => 'admin@test.com',
				'password' => 'password',
				'language' => 'en',
				'name' => 'Test Admin'
			]);
	
			$this->call([
				DatabaseSeeder::class,
			]);
	
			$admin->assignRole(Roles::where('super_admin', true)->firstOrFail());
		});
    }
}

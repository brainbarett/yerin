<?php

namespace Database\Seeders;

use App\Enums\Permissions\RealEstate\Features as FeaturesPermissions;
use App\Enums\Permissions\RealEstate\Properties as PropertiesPermissions;
use App\Models\Permissions;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(PropertiesPermissions::values() as $permission) {
			Permissions::firstOrCreate([
				'name' => $permission
			]);
		}

        foreach(FeaturesPermissions::values() as $permission) {
			Permissions::firstOrCreate([
				'name' => $permission
			]);
		}
    }
}

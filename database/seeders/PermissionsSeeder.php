<?php

namespace Database\Seeders;

use App\Enums\RealEstate\Permissions\AmenitiesPermissions;
use App\Enums\RealEstate\Permissions\PropertiesPermissions;
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
        foreach (array_merge(PropertiesPermissions::values(), AmenitiesPermissions::values()) as $permission) {
            Permissions::firstOrCreate([
                'name' => $permission,
            ]);
        }
    }
}

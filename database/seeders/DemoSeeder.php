<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\Users;
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
            $user = Users::create([
                'email' => 'admin@test.com',
                'password' => 'password',
                'language' => 'en',
                'name' => 'Test Admin',
            ]);

            $this->call([
                DatabaseSeeder::class,
            ]);

            $user->assignRole(Roles::where('super_admin', true)->firstOrFail());
        });
    }
}

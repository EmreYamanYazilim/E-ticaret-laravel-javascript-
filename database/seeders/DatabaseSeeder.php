<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Category\CategorySeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\User\IntitializeUserSeeder;
use Database\Seeders\RolePermissions\GeneralRolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            GeneralRolePermissionSeeder::class,
            IntitializeUserSeeder::class,
        ]);
    }
}

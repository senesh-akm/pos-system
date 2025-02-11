<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $cashier = Role::create(['name' => 'cashier']);

        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'process sales']);

        $admin->givePermissionTo(['manage products', 'process sales']);
        $cashier->givePermissionTo('process sales');

        Role::firstOrCreate(['name' => 'cashier']);
    }
}

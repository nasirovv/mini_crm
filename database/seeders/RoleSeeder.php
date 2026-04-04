<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage-users',
            'manage-customers',
            'manage-tickets',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $admin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());


        $manager = \Spatie\Permission\Models\Role::create(['name' => 'manager']);
        $manager->givePermissionTo(['manage-tickets']);

    }
}

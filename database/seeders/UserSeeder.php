<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'name'  => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');

        $manager = User::factory()->create([
            'name'  => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('manager123'),
        ]);
        $manager->assignRole('manager');

        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('manager');
        });
    }
}

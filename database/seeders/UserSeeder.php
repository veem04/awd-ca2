<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::where('name', 'admin')->first();
        $role_user = Role::where('name', 'user')->first();

        $admin = new User;
        $admin->name = 'vi';
        $admin->email = 'N00220460@iadt.ie';
        $admin->password = 'secret123';
        $admin->save();

        // attach the admin role to the user created above
        $admin->roles()->attach($role_admin);

        $notAdmin = new User;
        $notAdmin->name = 'powerless';
        $notAdmin->email = 'example@example.com';
        $notAdmin->password = 'example';
        $notAdmin->save();

        $notAdmin->roles()->attach($role_user);

        User::factory()
            ->hasAttached($role_user)
            ->count(5)
            ->create();
    }
}

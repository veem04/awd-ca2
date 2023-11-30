<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Game;
use App\Models\Genre;
use App\Models\GameEntry;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->name = 'vi';
        $admin->email = 'N00220460@iadt.ie';
        $admin->password = 'secret123';
        $admin->is_admin = true;
        $admin->save();

        $notAdmin = new User;
        $notAdmin->name = 'powerless';
        $notAdmin->email = 'example@example.com';
        $notAdmin->password = 'example';
        $notAdmin->is_admin = false;
        $notAdmin->save();

        User::factory()
            ->count(5)
            ->create();


    }
}

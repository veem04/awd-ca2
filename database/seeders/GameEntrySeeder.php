<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GameEntry;
use App\Models\User;


class GameEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $userIds = User::all()->pluck('id')->toArray();
        foreach($userIds as $userId){
            GameEntry::Factory()
                ->count(3)
                ->create(['user_id' => $userId]);
        }
    }
}

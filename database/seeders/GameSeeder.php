<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Genre;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Game::factory()
            ->count(15)
            ->create();

        $genres = Genre::all();

        Game::all()->each(function ($game) use ($genres) { 
            $game->genres()->attach(
                $genres->random(5)->pluck('id')->toArray()
            ); 
        });
    }
}

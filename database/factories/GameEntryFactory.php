<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GameEntry;
use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameEntry>
 */
class GameEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // array of all existing game IDs
        $gameIds = Game::all()->pluck('id')->toArray();
        
        // choose a date in the last 10 years
        $startDate = $this->faker->dateTimeThisDecade()->format('Y-m-d');
        // choose a date between the start date and now
        $endDate = $this->faker->dateTimeBetween($startDate)->format('Y-m-d');

        // this data is specific to each user for each game
        return [
            'game_id' => $this->faker->randomElement($gameIds),
            'status' => $this->faker->randomElement(GameEntry::$statusEnum),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'score' => $this->faker->randomDigit(),
            'review' => $this->faker->text(100),
        ];
    }
}

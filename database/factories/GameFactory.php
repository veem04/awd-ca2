<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Publisher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $publisherIds = Publisher::all()->pluck('id')->toArray();

        return [
            'title' => $this->faker->unique()->words(3, true),
            'publisher_id' => $this->faker->randomElement($publisherIds),
        ];
    }
}

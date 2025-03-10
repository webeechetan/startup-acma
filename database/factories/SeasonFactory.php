<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Season;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Season>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Season::class;
    public function definition(): array
    {
        static $seasonCount = 1;

        $startDate = fake()->dateTimeBetween('-1 years', 'now');
        $endDate = fake()->dateTimeBetween($startDate, '+1 years');

        return [
            'name' => 'Season ' . $seasonCount++,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => false,
        ];
    }
}

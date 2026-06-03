<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewLetter>
 */
class NewLetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company,
            'description' => $this->faker->sentence,
            'thumbnail' => '',
            'created_at' => $this->faker->unique()->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
        ];
    }
}

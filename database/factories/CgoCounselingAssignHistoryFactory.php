<?php

namespace Database\Factories;

use App\Models\CgoCounseling;
use App\Models\CgoUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CgoCounselingAssignHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'counseling_id' => $this->faker->randomElement(CgoCounseling::pluck('id')->toArray()),
            'assignee_from' => json_encode([$this->faker->randomElement(CgoUser::pluck('id')->toArray())]), // Example of previous assignees
            'assignee_to' => $this->faker->randomElement(CgoUser::pluck('id')->toArray()),
            'time' => $this->faker->numberBetween(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

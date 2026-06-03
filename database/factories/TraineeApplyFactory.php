<?php

namespace Database\Factories;

use App\Models\CgoUser;
use App\Models\Job;
use App\Models\TraineeApply;
use App\Models\TraineeUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TraineeApply>
 */
class TraineeApplyFactory extends Factory
{
    protected $model = TraineeApply::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => $this->faker->randomElement(Job::pluck('id')->toArray()),
            'trainee_id' => $this->faker->randomElement(TraineeUser::pluck('id')->toArray()),
            'apply_time' => date("Y-m-d H:i:s"),
            'read' => date("Y-m-d H:i:s"),
            'selected' => date("Y-m-d H:i:s") ,
            'selected_by' => $this->faker->randomElement(CgoUser::pluck('id')->toArray()),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }
}

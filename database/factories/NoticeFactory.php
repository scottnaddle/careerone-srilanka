<?php

namespace Database\Factories;

use App\Enums\NoticeTypeEnums;
use App\Models\AdminUser;
use App\Models\CodeManagement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'type' => $this->faker->randomElement(CodeManagement::where('module', 'notice_type')->pluck('code_id')->toArray()),
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'created_by' => $this->faker->randomElement(AdminUser::pluck('id')->toArray()),
        ];
    }
}

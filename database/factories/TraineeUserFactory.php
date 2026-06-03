<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Institute;
use App\Models\NVQLevel;
use App\Models\Occupation;
use App\Models\TraineeUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TraineeUserFactory extends Factory
{
    protected $model = TraineeUser::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nic' => $this->generateUniqueNic(),
            'username' => $this->faker->unique()->word,
            'password' => bcrypt('Videa@2024'),
            'full_name' => $this->faker->firstName .' '.$this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'telephone' => $this->faker->phoneNumber,
            'email_verified_at' => time(),
        ];
    }

    private function generateUniqueNic(): string
    {
        if (rand(0, 1)) {
            return $this->faker->unique()->regexify('[0-9]{9}[A-Z]');
        } else {
            return $this->faker->unique()->regexify('[0-9]{12}');
        }
    }
}

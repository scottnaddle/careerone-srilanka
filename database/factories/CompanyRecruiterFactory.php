<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Institute;
use App\Models\CompanyRecruiter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyRecruiterFactory extends Factory
{
    protected $model = CompanyRecruiter::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->word,
            'password' => bcrypt('Videa@2024'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'telephone' => $this->faker->phoneNumber,
            'company_id' => $this->faker->randomElement(Company::pluck('id')->toArray()),
            'email_verified_at' => now(),
            'verify_at' => now(),
            'verify_by' => 1,
        ];
    }

}

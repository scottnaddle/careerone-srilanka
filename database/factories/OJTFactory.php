<?php

namespace Database\Factories;

use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\OJT;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OJT>
 */
class OJTFactory extends Factory
{
    protected $model = OJT::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->jobTitle;
        return [
            'title' => $title,
            'sector_id' => $this->faker->randomElement(Sector::pluck('id')->toArray()),
            'company_id' => $this->faker->randomElement(Company::pluck('id')->toArray()),
            'nvq_level' => $this->faker->numberBetween(1, 6),
            'number_of_recruitment' => $this->faker->numberBetween(1, 100000),
            'registration_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'working_day' => $this->faker->randomElement(['Monday to Friday', 'Saturday and Sunday', 'Flexible']),
            'working_date' => $this->faker->dateTimeBetween('-1 day', '+1 day'),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'min_salary' => $this->faker->numberBetween(30000, 50000),
            'max_salary' => $this->faker->numberBetween(60000, 100000),
            'discussion_available' => $this->faker->numberBetween(0, 1),
            'gender' => $this->faker->numberBetween(1, 3),
            'min_age' => $this->faker->numberBetween(21, 25),
            'max_age' => $this->faker->numberBetween(35, 50),
            'age_limitation' => $this->faker->numberBetween(0, 1),
            'min_work_experience' => $this->faker->numberBetween(1, 3) . ' years',
            'max_work_experience' => $this->faker->numberBetween(4, 10) . ' years',
            'work_experience_limitation' => $this->faker->numberBetween(0, 1),
            'required_skills' => $this->faker->words(5, true),
            'application_starttime' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'application_endtime' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'slug' => Str::slug($title, '-', 'ta'),
            'hr_name' => $this->faker->name,
            'hr_email' => $this->faker->email,
            'hr_contact_info' => $this->faker->phoneNumber,
            'roles' => $this->faker->paragraph,
            'status' => $this->faker->numberBetween(0, 1),
            'created_by' => $this->faker->randomElement(CompanyRecruiter::pluck('id')->toArray()),
        ];
    }
}

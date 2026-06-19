<?php

namespace Database\Seeders;

use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\Job;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        for ($i = 0; $i < 100; $i++) {
            $title = $faker->jobTitle;
            $create_at = $faker->dateTimeBetween('-1 years', 'now');
            Job::create([
                'title' => $title,
                'job_type' => $faker->randomElement([1, 2, 3]),//['Permanent', 'Contract-based']
                'job_location' => $faker->randomElement([1, 2]),
                'sector_id' => $faker->randomElement(Sector::pluck('id')->toArray()),
                'company_id' => $faker->randomElement(Company::pluck('id')->toArray()),
                'working_day' => $faker->randomElement(['mon,tue,wed,thu,fri', 'sat,sun']),
                'start_time' => $faker->time('H:i'),
                'end_time' => $faker->time('H:i'),
                'min_salary' => $faker->numberBetween(30000, 50000),
                'max_salary' => $faker->numberBetween(60000, 100000),
                'gender' => $faker->numberBetween(1, 3),
                'min_age' => $faker->numberBetween(21, 25),
                'max_age' => $faker->numberBetween(35, 50),
                'min_work_experience' => $faker->numberBetween(1, 3) . ' years',
                'max_work_experience' => $faker->numberBetween(4, 10) . ' years',
                'required_skills' => $faker->words(5, true),
                'application_starttime' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'application_endtime' => $faker->dateTimeBetween('+1 month', '+2 months'),
                'slug' => Str::slug($title, '-', 'ta'),
                'hr_name' => $faker->name,
                'hr_email' => $faker->email,
                'hr_contact_info' => $faker->phoneNumber,
                'roles' => $faker->paragraph,
                'status' => $faker->numberBetween(0, 1),
                'created_by' => $faker->randomElement(CompanyRecruiter::pluck('id')->toArray()),
                'created_at' => $create_at,
                'updated_at' => $create_at,
            ]);
        }
    }
}

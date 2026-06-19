<?php

namespace Database\Seeders;

use App\Models\JobInformation;
use App\Models\Sector;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $knowledge = [];
        $skills = [];
        $related_occupations = [];
        $benefits = [];
        for ($i = 0; $i < 5; $i++) {
            $knowledge[$i]['value'] = $faker->numberBetween(10,100);
            $knowledge[$i]['text'] = $faker->word(5);
            $skills[$i]['value'] = $faker->numberBetween(10,100);
            $skills[$i]['text'] = $faker->word(5);
            $related_occupations[] = $faker->word(5);
            $benefits[] = $faker->word(5);
        }
        for ($i = 0; $i < 100; $i++) {
            $title = $faker->jobTitle;
            JobInformation::create([
                'title' => $title,
                'slug' => Str::slug($title, '-', 'ta'),
                'sector_id' => $faker->randomElement(Sector::pluck('id')->toArray()),
                'description' => $faker->paragraph(10),
                'knowledge' => json_encode($knowledge),
                'skills' => json_encode($skills),
                'duties_of_the_job' => $faker->paragraph(10),
                'related_occupations' => json_encode($related_occupations),
                'benefits' => json_encode($benefits),
                'expected_income_per_month' => "800$ - 10000$",
                'created_by' => 1,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\TraineeUser;
class TraineeUserCVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('trainee_user_c_v_s')->delete();
        $faker = Faker::create();
        $trainees = TraineeUser::all();
//        for ($i = 1; $i <= 30; $i++) {
        foreach ($trainees as $trainee) {
            DB::table('trainee_user_c_v_s')->insert([
                'trainee_user_id' => $trainee->id,
                'short_bio' => $faker->word,
                'basic_information' => $faker->paragraph,
                'address' => $faker->address,
                'education' => json_encode([
                    [
                        'degree' => 'B.Sc in ' . $faker->word,
                        'institution' => $faker->company,
                        'start_year' => $faker->year,
                        'end_year' => $faker->year
                    ],
                    [
                        'degree' => 'M.Sc in ' . $faker->word,
                        'institution' => $faker->company,
                        'start_year' => $faker->year,
                        'end_year' => $faker->year
                    ]
                ]),
                'experience' => json_encode([
                    [
                        'name' => 'B.Sc in ' . $faker->word,
                        'description' => $faker->word,
                        'start_year' => $faker->year,
                        'end_year' => $faker->year
                    ],
                    [
                        'name' => 'B.Sc in ' . $faker->word,
                        'description' => $faker->word,
                        'start_year' => $faker->year,
                        'end_year' => $faker->year
                    ],
                ]),
                'certificate' => json_encode([
                    [
                        'name' => $faker->word . ' Certification',
                        'nvq' => $faker->numberBetween(1, 6),
                        'start_year' => $faker->year,
                        'end_year' => $faker->year
                    ],
                    [
                        'name' => $faker->word . ' Certification',
                        'nvq' => $faker->numberBetween(1, 6),
                        'start_year' => $faker->year,
                        'end_year' => $faker->year
                    ]
                ]),
                'expertise' => json_encode([
                    [
                        'name' => $faker->word,
                        'description' => $faker->sentence()
                    ],
                    [
                        'name' => $faker->word,
                        'description' => $faker->sentence()
                    ],
                ]),
                'language' => json_encode([
                    [
                        'name' => $faker->word,
                        'proficiency' => $faker->randomElement(['Basic', 'Intermediate', 'Fluent'])
                    ],
                    [
                        'name' => $faker->word,
                        'proficiency' => $faker->randomElement(['Basic', 'Intermediate', 'Fluent'])
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

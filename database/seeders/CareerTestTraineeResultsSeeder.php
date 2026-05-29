<?php

namespace Database\Seeders;

use App\Models\CareerTest;
use App\Models\TraineeUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class CareerTestTraineeResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();


        \DB::table('career_test_trainee_results')->insert([
            'name' => $faker->name,
            'nic' => rand(111111111111,999999999999),
            'trainee_id' => $faker->randomElement(TraineeUser::pluck('id')->toArray()),
            'test_type' => '2',
            'career_test_id' => 2,
            'result' => '{"realistic":11,"investigative":11,"artistic":11,"social":11,"enterprising":11,"conventional":11}',
            'note' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        \DB::table('career_test_trainee_results')->insert([
            'name' => $faker->name,
            'nic' => rand(111111111111,999999999999),
            'trainee_id' => $faker->randomElement(TraineeUser::pluck('id')->toArray()),
            'test_type' => '1',
            'career_test_id' => 1,
            'result' => '{"outdoor":0,"practical":18,"science":15,"creative":12,"business":6,"office":3,"social":9}',
            'note' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        \DB::table('career_test_trainee_results')->insert([
            'name' => $faker->name,
            'nic' => rand(111111111111,999999999999),
            'trainee_id' => $faker->randomElement(TraineeUser::pluck('id')->toArray()),
            'test_type' => '1',
            'career_test_id' => 1,
            'result' => '{"outdoor":7,"practical":6,"science":5,"creative":11,"business":11,"office":7,"social":16}',
            'note' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        \DB::table('career_test_trainee_results')->insert([
            'name' => $faker->name,
            'nic' => rand(111111111111,999999999999),
            'trainee_id' => $faker->randomElement(TraineeUser::pluck('id')->toArray()),
            'test_type' => '1',
            'career_test_id' => 1,
            'result' => '{"outdoor":8,"practical":10,"science":7,"creative":10,"business":8,"office":9,"social":11}',
            'note' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

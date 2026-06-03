<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\TvetHeadquater;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TvetHeadquaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            TvetHeadquater::create([
                'name' => 'Headquater '.$i,
                'description' => 'Description test',
                'prov_id' => $faker->randomElement(Province::pluck('id')->toArray()),
                'dist_id' => $faker->randomElement(District::pluck('id')->toArray()),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

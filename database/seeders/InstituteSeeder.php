<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Institute;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) {

            $create_at = $faker->dateTimeBetween('-1 years', 'now');

            Institute::create([
                'name' => 'Institute '.$i,
                'detail' => $faker->paragraph,
                'phone' => $faker->phoneNumber,
                'fax' => $faker->phoneNumber,
                'prov_id' => '',
                'dist_id' => $faker->randomElement(District::pluck('id')->toArray()),
                'ds_id' => '1304',
                'created_by' => 1,
                'created_at' => $create_at,
                'updated_at' => $create_at,
            ]);
        }
    }
}

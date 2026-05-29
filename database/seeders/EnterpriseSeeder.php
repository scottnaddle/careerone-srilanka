<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
//        for ($i = 0; $i < 10; $i++) {
            DB::table('enterprises')->insert([
                'name' => 'The test enterprise 1',
                'description' => $faker->paragraph(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
//        }
    }
}

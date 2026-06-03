<?php

namespace Database\Seeders;

use App\Models\CareerTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('career_tests')->delete();
        CareerTest::create([
            'test_name' => 'Career Interest Test',
            'content' => json_encode([]),
            'description' => 'The Career Interest Test',
            'expired_date' => '',
            'test_type' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        CareerTest::create([
            'test_name' => 'Career Key Test',
            'content' => json_encode([]),
            'description' => 'The Career Key Test',
            'expired_date' => '',
            'test_type' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        CareerTest::create([
            'test_name' => 'Interest and Ability Test',
            'content' => json_encode([]),
            'description' => 'The Interest and Ability Test',
            'expired_date' => '',
            'link' => 'https://www.lankaeducator.com/ctest/moreinfo4.html',
            'test_type' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        CareerTest::create([
            'test_name' => 'Interest, Ability and Personality Test',
            'content' => json_encode([]),
            'description' => 'The Interest, Ability and Personality Test',
            'expired_date' => '',
            'link' => 'https://www.lankaeducator.com/ctest/moreinfo5.html',
            'test_type' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

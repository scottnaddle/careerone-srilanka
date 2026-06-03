<?php

namespace Database\Seeders;

use App\Models\CareerGuidance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerGuidanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CareerGuidance::factory()->count(30)->create();
    }
}

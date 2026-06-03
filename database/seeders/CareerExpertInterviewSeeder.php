<?php

namespace Database\Seeders;

use App\Models\CareerExpertInterview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerExpertInterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CareerExpertInterview::factory()->count(10)->create();
    }
}

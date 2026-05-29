<?php

namespace Database\Seeders;

use App\Models\OJT;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OJTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OJT::factory()->count(50)->create();
    }
}

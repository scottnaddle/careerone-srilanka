<?php

namespace Database\Seeders;

use App\Models\CounselingField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CgoCounselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CounselingField::factory()
            ->count(3)
            ->create();
    }
}

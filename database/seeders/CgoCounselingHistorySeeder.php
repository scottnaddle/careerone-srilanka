<?php

namespace Database\Seeders;

use App\Models\CgoCounselingAssignHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CgoCounselingHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CgoCounselingAssignHistory::factory()->count(30)->create();
    }
}

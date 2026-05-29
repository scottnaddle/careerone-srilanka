<?php

namespace Database\Seeders;

use App\Models\TvetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TvetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tvets = [
            ['name' => 'DTET', 'description' => ''],
            ['name' => 'NAITA', 'description' => ''],
            ['name' => 'VTA', 'description' => ''],
            ['name' => 'CoT (College of Technology)', 'description' => ''],
            ['name' => 'TC (Technical College)', 'description' => ''],
            ['name' => 'UC (UNIVOTEC and University Colleges)', 'description' => ''],
            ['name' => 'DVTC (District Vocational Training Centers)', 'description' => ''],
            ['name' => 'NVTI (National Vocational Training Institute)', 'description' => ''],
            ['name' => 'VTC (Vocational Training Center)', 'description' => ''],
            ['name' => 'Ocean University of Sri Lanka (OCUSL)', 'description' => ''],
            ['name' => 'Ceylon German Training Institute', 'description' => ''],
            ['name' => 'Sri Lanka – German Training Institute', 'description' => ''],
            ['name' => 'National Youth Service Council', 'description' => ''],
        ];

        foreach ($tvets as $tvet) {
            TvetType::create([
                'name' => $tvet['name'],
                'description' => $tvet['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

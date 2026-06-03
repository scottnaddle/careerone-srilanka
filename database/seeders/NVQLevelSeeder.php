<?php

namespace Database\Seeders;

use App\Models\NVQLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NVQLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            NVQLevel::create([
                'name' => 'NVQ level '.$i,
                'description' => 'NVQ level '.$i,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}

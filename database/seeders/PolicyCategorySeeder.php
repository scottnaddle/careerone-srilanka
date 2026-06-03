<?php

namespace Database\Seeders;

use App\Models\PolicyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        PolicyCategory::factory()->count(5)->create();
        // Define policy data
        $policies = [
            [
                'name' => 'ILO',
                'description' => 'International Labour Organization policy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ministry of Human Resource and Empowerment',
                'description' => 'Policies related to human resource and empowerment managed by the ministry',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NHRDC (National Human Resource and Development Council of Sri Lanka)',
                'description' => 'Policies by the National Human Resource and Development Council of Sri Lanka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert policies into the database
        foreach ($policies as $policy) {
            PolicyCategory::create($policy);
        }
    }
}

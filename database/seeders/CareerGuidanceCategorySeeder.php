<?php

namespace Database\Seeders;

use App\Models\CareerGuidanceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CareerGuidanceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Resume/Cover Letter Writing Tips',
            'Interview Strategies',
            'Employment Tips',
            'Success Stories',
            'Employment Videos'
        ];

        foreach ($categories as $category) {
            CareerGuidanceCategory::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}

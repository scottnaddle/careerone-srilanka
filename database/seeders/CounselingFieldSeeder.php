<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounselingFieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            ['name' => 'Career Guidance'],
            ['name' => 'Education Counseling'],
            ['name' => 'Job Seeking Support'],
        ];

        foreach ($fields as $field) {
            DB::table('counseling_fields')->updateOrInsert(
                ['name' => $field['name']],
                $field
            );
        }
    }
}

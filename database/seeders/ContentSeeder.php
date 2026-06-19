<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $system = ['cgo', 'company'];
        $status = [0, 1, 2]; //0:request , 1: confirm , 2: reject
        for ($i = 0; $i < 10; $i++) {
            $title = $faker->sentence(2);
            DB::table('contents')->insert([
                'title' => $title,
                'content_type' => 'video',
                'slug' => Str::slug($title, '-', 'ta'),
                'intro' => $faker->paragraph(10),
                'attachment_details' => json_encode([]),
                'video_url' => 'https://www.youtube.com/watch?v=u8sIacxJebI',
                'author' => '',
                'license' => '',
                'size' => '',
                'status' => $status[array_rand($status, 1)],
                'system' => $system[array_rand($system, 1)],
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $title = $faker->sentence(2);
            DB::table('contents')->insert([
                'title' => $title,
                'content_type' => 'pdf',
                'slug' => Str::slug($title, '-', 'ta'),
                'intro' => $faker->paragraph(10),
                'attachment_details' => json_encode(['file_name' => $faker->word . '.pdf', 'file_size' => $faker->numberBetween(1000, 10000)]),
                'video_url' => '',
                'author' => $faker->name,
                'license' => '',
                'size' => '',
                'status' => $status[array_rand($status, 1)],
                'system' => $system[array_rand($system, 1)],
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $title = $faker->sentence(2);
            DB::table('contents')->insert([
                'title' => $title,
                'content_type' => 'doc',
                'slug' => Str::slug($title, '-', 'ta'),
                'intro' => $faker->paragraph(10),
                'attachment_details' => json_encode(['file_name' => $faker->word . '.pdf', 'file_size' => $faker->numberBetween(1000, 10000)]),
                'video_url' => '',
                'author' => $faker->name,
                'license' => '',
                'size' => '',
                'status' => $status[array_rand($status, 1)],
                'system' => $system[array_rand($system, 1)],
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

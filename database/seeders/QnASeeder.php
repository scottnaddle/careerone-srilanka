<?php

namespace Database\Seeders;

use App\Models\CgoUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QnASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $system = ['cgo'];
        $status = [0, 1, 2]; //0:request , 1: confirm , 2: reject
        foreach (range(1, 10) as $index) {
            $title = $faker->sentence;
            DB::table('q_n_a_s')->insert([
                'status' => $status[array_rand($status, 1)],
                'title' => $title,
                'slug' => Str::slug($title, '-', 'ta'),
                'description' => $faker->paragraph(10),
                'system' => $system[array_rand($system, 1)],
                'created_by' => $faker->randomElement(CgoUser::pluck('id')->toArray()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

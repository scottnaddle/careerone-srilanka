<?php

namespace Database\Seeders;

use App\Models\TraineeUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TraineeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trainee_users')->delete();
        for ($i = 1; $i <= 10; $i++) {
            TraineeUser::factory(['email' => 'trainee_user' . $i . '@gmail.com'])
                ->create();
        }
    }
}

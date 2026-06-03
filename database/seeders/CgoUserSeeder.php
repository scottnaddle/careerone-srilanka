<?php

namespace Database\Seeders;

use App\Models\CgoUser;
use Database\Factories\CgoUserFactory;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CgoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cgo_users')->delete();
        for ($i = 1; $i <= 20; $i++) {
            CgoUser::factory()->create([
                'email' => 'cgouser' . $i . '@gmail.com',
            ]);
        }
    }
}

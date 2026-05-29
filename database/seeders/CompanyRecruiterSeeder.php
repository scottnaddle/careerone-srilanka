<?php

namespace Database\Seeders;

use App\Models\CompanyRecruiter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyRecruiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_recruiters')->delete();
        for ($i = 1; $i <= 10; $i++) {
            CompanyRecruiter::factory(['email' => 'company_recruiter'.$i.'@gmail.com'])
                ->create();
        }
    }
}

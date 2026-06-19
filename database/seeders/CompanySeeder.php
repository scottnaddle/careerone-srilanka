<?php

namespace Database\Seeders;

use App\Models\CoBusiness;
use App\Models\CodeManagement;
use App\Models\Company;
use App\Models\District;
use App\Models\Enterprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $office_types = [1, 2];

        for ($i = 1; $i <= 10; $i++) {
            $name = 'Company' . $i;
            Company::create([
                'name' => $name,
                'logo' => env('APP_URL') . '/images/company-default.png',
                'email' => 'company'.$i.'@gmail.com',
                'date_of_establishment' => now(),
                'business_registration_number' => $faker->randomNumber(9, true),
                'number_workers' => $faker->randomNumber(3, false),
                'company_information' => $faker->randomElement(CodeManagement::where('module', 'company_information')->pluck('code_id')->toArray()),
                'website' => $faker->url(),
                'attachment_details' => json_encode([]),
                'office_type' => $faker->randomElement($office_types),
                'name_of_representation' => $faker->name,
                'co_business' =>  "",
                'enterprise_id' =>  $faker->randomElement(Enterprise::pluck('id')->toArray()),
                'district_id' => $faker->randomElement(District::pluck('id')->toArray()),
                'slug' => Str::slug($name, '-', 'ta'),
                'verified_at' => now(),
                'verified_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

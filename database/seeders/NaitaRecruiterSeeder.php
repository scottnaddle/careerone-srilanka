<?php
// Database/Seeders/NaitaRecruiterSeeder.php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NaitaRecruiterSeeder extends Seeder
{
    public function run(): void
    {
        $staffList = [
            ['first_name' => 'Mr.H.A', 'last_name' => 'Ravindra', 'email' => 'haravindra2637@gmail.com', 'password' => 'Welcome_haravindra2637', 'phone' => '0714553768', 'district' => 'Colombo'],
            ['first_name' => 'Mr.G.G.N', 'last_name' => 'Pushpakumara', 'email' => 'ggnpkumara@gmail.com', 'password' => 'Welcome_ggnpkumara', 'phone' => '0714553800', 'district' => 'Colombo'],
            ['first_name' => 'Mr.W.M.M.P', 'last_name' => 'Sandaruwan', 'email' => 'malithnaita@gmail.com', 'password' => 'Welcome_malithnaita', 'phone' => '0719255716', 'district' => 'Colombo'],
            ['first_name' => 'Mr.R.K.G', 'last_name' => 'Rajakaruna', 'email' => 'krajakaruna@naita.edu.lk', 'password' => 'Welcome_krajakaruna', 'phone' => '0710921851', 'district' => 'Gampaha'],
            ['first_name' => 'Mrs.G.R', 'last_name' => 'Jesudasan', 'email' => 'generalprofgayu@gmail.com', 'password' => 'Welcome_generalprofgayu', 'phone' => '0772809431', 'district' => 'Gampaha'],
            ['first_name' => 'Mrs.K.A', 'last_name' => 'Nalika Nishanthi', 'email' => 'nalikanishanthi.naita@gmail.com', 'password' => 'Welcome_nalikanishanthi', 'phone' => '0714553798', 'district' => 'Gampaha'],
            ['first_name' => 'Mrs.K.K', 'last_name' => 'Nishshanka', 'email' => 'kumudininishshanka@gmail.com', 'password' => 'Welcome_kumudininishshanka', 'phone' => '0717459899', 'district' => 'Kurunegala'],
            ['first_name' => 'Mr.T.M.T.B', 'last_name' => 'Karunarathne', 'email' => 'ruwansaelectropower@gmail.com', 'password' => 'Welcome_ruwansaelectropower', 'phone' => '0714553749', 'district' => 'Kurunegala'],
            ['first_name' => 'Mrs.U.H.E.S', 'last_name' => 'Rathnayake', 'email' => 'sewwandir708@gmail.com', 'password' => 'Welcome_sewwandir708', 'phone' => '0717459427', 'district' => 'Kurunegala'],
            ['first_name' => 'Mr.Milan ', 'last_name' => 'Wickramasinghe', 'email' => 'milannaita1982@gmail.com', 'password' => 'Welcome_milannaita1982', 'phone' => '0710757704', 'district' => 'Kalutara'],
            ['first_name' => 'Mr.T.M', 'last_name' => 'Amarawansha', 'email' => 'tmamarawansha@gmail.com', 'password' => 'Welcome_tmamarawansha', 'phone' => '0718705361', 'district' => 'Kalutara'],
            ['first_name' => 'Mrs.M.A.L', 'last_name' => 'Hansikа', 'email' => 'lahirunih@gmail.com', 'password' => 'Welcome_lahirunih', 'phone' => '0711827253', 'district' => 'Kalutara'],
            ['first_name' => 'Mr. M.D.C', 'last_name' => 'Brashil', 'email' => 'pansilu74@gmail.com', 'password' => 'Welcome_pansilu74', 'phone' => '0718705366', 'district' => 'Galle'],
            ['first_name' => 'Mrs.M.P', 'last_name' => 'Wickramarachchi', 'email' => 'maneshapr@gmail.com', 'password' => 'Welcome_maneshapr', 'phone' => '0711192444', 'district' => 'Galle'],
            ['first_name' => 'Mrs.T.G.K', 'last_name' => 'Mangalika', 'email' => 'krishanthimangalika@gmail.com', 'password' => 'Welcome_krishanthimangalika', 'phone' => '0714562634', 'district' => 'Galle'],
            ['first_name' => 'Mr.A.C', 'last_name' => 'Saman Kumara', 'email' => 'anilsamankumara89@gmail.com', 'password' => 'Welcome_anilsamankumara89', 'phone' => '0718705321', 'district' => 'Kandy'],
            ['first_name' => 'Mr.S.A', 'last_name' => 'Meddewithana', 'email' => 'sanjeewa.naita@gmail.com', 'password' => 'Welcome_sanjeewa', 'phone' => '0717459807', 'district' => 'Kandy'],
            ['first_name' => 'Mr.M.W.M.P', 'last_name' => 'Wijesinghe', 'email' => 'pwijesinghe54@gmail.com', 'password' => 'Welcome_pwijesinghe54', 'phone' => '0710922111', 'district' => 'Kandy'],
            ['first_name' => 'Mr', 'last_name' => 'Yang', 'email' => 'skehsleh@gmail.com', 'password' => 'Welcome_skehsleh', 'phone' => '0710922000', 'district' => 'Colombo'],
        ];

        $company = Company::create([
            'name' => "Organization_NAITA",
            'logo' => null,
            'email' => 'adcg@naita.gov.lk',
            'hotline' => null,
            'address' => 'Colombo',
            'date_of_establishment' => null,
            'business_registration_number' => null,
            'number_workers' => '18',
            'website' => null,
            'attachment_details' => null,
            'office_type' => '1',
            'name_of_representation' => null,
            'co_business' => null,
            'enterprise_id' => null,
            'district_id' => 'D10',
            'slug' => Str::slug("Organization_NAITA"),
            'services' => null,
            'short_bio' => null,
            'company_information' => '6',
            'verified_at' => now(),
            'verified_by' => 2,
            'active' => true,
        ]);

        foreach ($staffList as $item) {
            CompanyRecruiter::create([
                'first_name' => $item['first_name'],
                'last_name' => $item['last_name'],
                'username' => Str::before($item['email'], '@'),
                'email' => $item['email'],
                'password' => bcrypt($item['password']),
                'telephone' => $item['phone'],
                'company_id' => $company->id,
                'active' => true,
                'verify_at' => now(),
                'verify_by' => 2,
                'email_verified_at' => now(),
            ]);

            $this->command->info("Created recruiter: {$item['email']}");
        }
    }
}

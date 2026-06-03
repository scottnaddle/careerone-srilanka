<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Mail\RecruiterAccountCreated;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NaitaRecruiterSeederTest extends Seeder {
    public function run(): void
    {
        $staffList = [
            ['first_name' => 'Mr.H.A', 'last_name' => 'Ravindra', 'email' => 'nluu246@gmail.com', 'phone' => '0714553722', 'district' => 'Colombo'],
            ['first_name' => 'Mr.G.G.N', 'last_name' => 'Pushpakumara', 'email' => 'nluu1235@gmail.com', 'phone' => '0714553810', 'district' => 'Colombo'],
            ['first_name' => 'Mr.W.M.M.P', 'last_name' => 'Sandaruwan', 'email' => 'oscar@videabiz.com', 'phone' => '0719255316', 'district' => 'Colombo'],
        ];
        $company = Company::create([
            'name' => "Organization_Videa",
            'logo' => '',
            'email' => 'videa@naita.gov.lk',
            'hotline' => '',
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
            'slug' => Str::slug("Organization_Videa"),
            'services' => null,
            'short_bio' => null,
            'company_information' => '6',
            'verified_at' => now(),
            'verified_by' => 2,
            'active' => true,
        ]);
        foreach ($staffList as $item) {
            $plainPassword = 'Videa@' . Str::random(5);

            $recruiter = CompanyRecruiter::create([
                'first_name' => $item['first_name'],
                'last_name' => $item['last_name'],
                'username' => Str::before($item['email'], '@'),
                'email' => $item['email'],
                'password' => bcrypt($plainPassword),
                'telephone' => $item['phone'],
                'company_id' => $company->id,
                'active' => true,
                'verify_at' => now(),
                'verify_by' => 2,
                'email_verified_at' => now(),
            ]);

            // 3. Gửi Mail (English)
            try {
                Mail::to($recruiter->email)->send(new RecruiterAccountCreated($recruiter, $plainPassword));
                $this->command->info("Created & Emailed: {$item['email']}");
            } catch (\Exception $e) {
                $this->command->error("Mail failed for: {$item['email']} - " . $e->getMessage());
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use App\Models\District;
use App\Models\Institute;
use App\Models\TvetHeadquater;
use App\Models\TvetType;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Superadmin user
        $create = AdminUser::create([
            'first_name' => 'Super',
            'nic' => '1235',
            'last_name' => 'Admin',
            'username' => 'admin@tvec.com',
            'password' => bcrypt('tvec2024'),
            'role' => 'superadmin',
            'phone' => '0213132112',
            'email' => 'admin@tvec.com',
            'tvet_type' => $faker->randomElement(TvetType::pluck('head_office_code')->toArray()),
            'email_verified_at' => now(),
            'verify_at' => now(),
            'verify_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Artisan::call('shield:super-admin', ['--user' => $create->id]);

        $create1 = AdminUser::create([
            'first_name' => 'Super',
            'nic' => '1235',
            'last_name' => 'Admin Videa',
            'username' => 'admin@videabiz.com',
            'password' => bcrypt('Videa@2024'),
            'role' => 'superadmin',
            'phone' => '0213132112',
            'email' => 'admin@videabiz.com',
            'tvet_type' => $faker->randomElement(TvetType::pluck('head_office_code')->toArray()),
            'email_verified_at' => now(),
            'verify_at' => now(),
            'verify_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Artisan::call('shield:super-admin', ['--user' => $create1->id]);

        $roles = DB::table('roles')->whereNot('name', operator: 'super_admin')->get();

    }
}

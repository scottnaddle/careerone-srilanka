<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\District;
use App\Models\Institute;
use App\Models\Sector;
use App\Models\TvetHeadquater;
use App\Models\TvetType;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $role = Role::firstOrCreate([
            'name' => 'SuperAdmin',
            'guard_name' => 'admin'
        ]);
        $permissions = Permission::all();
        $role->permissions()->sync($permissions->pluck('id'));
        $adminUser1 = AdminUser::create([
            'first_name' => 'Supper',
            'nic' => '1235',
            'last_name' => 'Admin',
            'username' => 'admin@videabiz.com',
            'password' => bcrypt('Videa@2024'),
            'role' => 'superadmin',
            'phone' => '0213132112',
            'email' => 'admin@videabiz.com',
            'tvet_type' => $faker->randomElement(TvetType::pluck('id')->toArray()),
            'verify_at' => date("Y-m-d H:i:s"),
            'verify_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        $adminUser2 = AdminUser::create([
            'first_name' => 'TVEC',
            'nic' => '123123123123',
            'last_name' => 'Admin',
            'username' => 'admin@tvec.com',
            'password' => bcrypt('tvec2024'),
            'role' => 'superadmin',
            'phone' => '0213132112',
            'email' => 'admin@tvec.com',
            'tvet_type' => $faker->randomElement(TvetType::pluck('id')->toArray()),
            'verify_at' => date("Y-m-d H:i:s"),
            'verify_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        $adminUser1->assignRole($role);
        $adminUser2->assignRole($role);
    }
}

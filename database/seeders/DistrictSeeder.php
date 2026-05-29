<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('districts')->delete();
        $districts = [
            [
                'id' => 'D10',
                'name' => 'Colombo',
                'prov_id' => 'P10',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D11',
                'name' => 'Kalutara',
                'prov_id' => 'P10',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D12',
                'name' => 'Gampaha',
                'prov_id' => 'P10',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D13',
                'name' => 'Matara',
                'prov_id' => 'P11',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D14',
                'name' => 'Galle',
                'prov_id' => 'P11',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D15',
                'name' => 'Hambantota',
                'prov_id' => 'P11',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D16',
                'name' => 'Jaffna',
                'prov_id' => 'P12',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D17',
                'name' => 'Vavuniya',
                'prov_id' => 'P12',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D18',
                'name' => 'Nuwara Eliya',
                'prov_id' => 'P13',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D19',
                'name' => 'Matale',
                'prov_id' => 'P13',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D20',
                'name' => 'Mannar',
                'prov_id' => 'P12',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D21',
                'name' => 'Kandy',
                'prov_id' => 'P13',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D22',
                'name' => 'Mullaitivu',
                'prov_id' => 'P12',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D23',
                'name' => 'Kilinochchi',
                'prov_id' => 'P12',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D25',
                'name' => 'Batticaloa',
                'prov_id' => 'P16',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D26',
                'name' => 'Ampara',
                'prov_id' => 'P16',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D27',
                'name' => 'Trincomalee',
                'prov_id' => 'P16',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D28',
                'name' => 'Anuradhapura',
                'prov_id' => 'P17',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D29',
                'name' => 'Polonnaruwa',
                'prov_id' => 'P17',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D30',
                'name' => 'Badulla',
                'prov_id' => 'P15',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D31',
                'name' => 'Monaragala',
                'prov_id' => 'P15',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D32',
                'name' => 'Ratnapura',
                'prov_id' => 'P18',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D33',
                'name' => 'Kegalle',
                'prov_id' => 'P18',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D35',
                'name' => 'Kurunegala',
                'prov_id' => 'P19',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 'D36',
                'name' => 'Puttalam',
                'prov_id' => 'P19',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
        ];

        DB::table('districts')->insert($districts);
    }
}

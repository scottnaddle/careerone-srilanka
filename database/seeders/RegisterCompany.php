<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegisterCompany extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => '99X Technology',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '65 Walrukarama Road, Colombo 3',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Abans',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => '498, Galle Road, Colombo 3, Sri Lanka',
                'business_registration_number' => 'PV 5301 PB/PQ'
            ],
            [
                'name' => 'ACECAM Pvt Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 419 2/1, Galle Road, Colombo 03',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Adventa Capital PVT LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '262 Kaduwela Road, Koswatta Battaramulla',
                'business_registration_number' => 'PV 00230412'
            ],
            [
                'name' => 'Agricutlure Sector Skills Council',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'Nipanatha Piayasa Elvitigala Mawatha Colombo 5',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Agro Culture Trades',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 73, Vihara Mawatha, Pepiliyana',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Aitken Spence Printing',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'Aitken Spence Printing and Packaging, Mawaramandiya',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Aitken Spence Travels',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '315 Vauxhall St, Colombo 00200',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Asian paints causeway',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Kalutara',
                'address' => '15, N, Panaduraoel Medis Mawatha, Modarawila Industrial Estate',
                'business_registration_number' => ''
            ],
            [
                'name' => 'ASIRI HEALTH',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '181 Bernard Soysa Mawatha, Colombo 00500',
                'business_registration_number' => ''
            ],
            [
                'name' => 'ASSOCICATION OF PACAGING CONSULTANTS',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '413/10 Temple Place, Pepiliyana, Borelesgamuwa',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Astron Limited',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => '688, Galle Rd, Ratmalana, Sri lanka.',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Aitken Spence',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '315, Vauxhall Street, Colombo 02',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Bankhill Educare',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '76, Ward Place, Colombo 07',
                'business_registration_number' => ''
            ],
            [
                'name' => 'BCS Sri Lanka',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => 'No. 129/2, Dutugemunu Street, Kohuwala',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Bopitiya Auto Enterprises',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Gampaha',
                'address' => '668 Nugape Pamunugama',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Brandix',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'No. 25, Rheinland Place, Colombo 03, Sri Lanka',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Brandix Corporate Campus',
                'office_type' => 'Branch',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'Brandix Corporate campus 157 Galle Road Ratmalana',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Brilliance Autolife',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Kurunegala',
                'address' => 'Mahasen mawatha, negombo rd, Kurunegala.',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Camera LK',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No 263, High level Rd, Colombo 05 Sri Lanka.',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Cargills (Ceylon) PLC',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 40, York Street, Colombo 01',
                'business_registration_number' => ''
            ],
            [
                'name' => 'C.D. de Fonseka & sons (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Kalutara',
                'address' => '37 Panadura - Niwdawa Rd, Panadura',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Ceylon National Chamber of Industries',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => 'Galleface Courts 2, Colombo 1',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Coca Cola Beverages Sri Lanka Limited',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'Thekkawatta, Biyagama, Sri Lanka',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Colombo Dockyard PLC',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 906, Port of Colombo, Colombo 15',
                'business_registration_number' => 'PQ50'
            ],
            [
                'name' => 'Debug Group of Companies',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '58/42nd Lane Wellawatta Colombo 6',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Diligent Solutions',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Gampaha',
                'address' => '715/1C , Gonawala ,Kelaniya',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Digital Net',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '4, 43 Mahalwarawa Rd, Pannipitiya 10230',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Dimo Lanka',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '65 Jetawana road, Colombo 14',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Durdans Hospital',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '3/ Alfred Place,Colombo 3',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Federation of IT Industry - Sri Lanka',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => 'No. 9A, 1/3, 4th Street, St. Anthonys Mawatha, Colombo 03',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Fonterra Brands Lanka PVT LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Gampaha',
                'address' => '100, Delgoda Rd, Biyagama, Sri Lanka.',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Grindlays Regency',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Kegalle',
                'address' => '514 Kurunagala Road, Thulhiriya Sri Lanka',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Hayleys',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '400 Deans Rd, Colombo 10',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Hemas consumer brands',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'Brebruk place, Colombo 02 Sri Lanka',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Hemas Hospitals',
                'office_type' => 'Branch',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'Wattala',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Isuru Engineering Company',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => 'No. 983, Pannipitiya Rd, Battaramulla, Sri Lanka.',
                'business_registration_number' => ''
            ],
            [
                'name' => 'JAT Holdings',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 351, Pannipitiya Road, Thalawathugoda',
                'business_registration_number' => ''
            ],
            [
                'name' => 'John Keells Group',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '117, Sir Chittampam A Gardiner Mw, Colombo 2',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Kent Engineering',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 27, Malwatte Avenue, Kohuwala, Nugegoda',
                'business_registration_number' => 'PV5635'
            ],
            [
                'name' => 'Kevilton Electrical Products (Pvt)',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '11, 1st cross street borupana road ratmalana, sri lanka',
                'business_registration_number' => ''
            ],
            [
                'name' => 'L.H Piyasena & Co (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '151 Nawala Road Narahenpita',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Lakro Packaging Industries',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Gampaha',
                'address' => '539/A/1 Kandy Road, Malwatta, Nittambuwa',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Lanka Ashok Leyland PLC',
                'office_type' => 'Headquater',
                'company_information' => 'Semi Government',
                'district' => 'Colombo',
                'address' => 'Panagoda, Homagama, Sri Lanka',
                'business_registration_number' => 'P010526'
            ],
            [
                'name' => 'Lanka Hospitals Corporation PLC',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => '578 Elvitigala Mawatha, Colombo 05, Sri Lanka',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Maga',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '200 Nawala Road, Narahenpita Colombo 5',
                'business_registration_number' => ''
            ],
            [
                'name' => 'Manufacturing and Engineering Services Industry Skill Council',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'MESSCO Room B, Level 2 OJT Building, NAITA, 971, Sri Jayawardenapura Mw, Rajagiriya',
                'business_registration_number' => ''
            ],
            [
                'name' => 'MAT International (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Kalutara',
                'address' => '52/1, Kavimani Gardens, Gunagamuwa, Bandaragama, Sri Lanka',
                'business_registration_number' => 'PV86666',
            ],
            [
                'name' => 'Nawaloka Construction (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '12 Floor Nawaloka Specialist Centre No 115 Sir James Pieris Mawatha Colombo 2',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Nestle Lanka Limited',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 440, T B Jayah Mawatha. Colombo 10',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Noritake Lanka Porcelain',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Matale',
                'address' => 'No. 30, Warakamura, Matale',
                'business_registration_number' => '',
            ],
            [
                'name' => 'OREK IT',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 34, Old Road, Nawinna, Mahara',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Organisation of Professional Association',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '275/75 PRf stanfley Wijesutriya Mawatha Colombo 7',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Packaging Consultant Association of Sri Lanka',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '77, Nungamugoda Road, Kelaniya, Sri Lanka',
                'business_registration_number' => '',
            ],
            [
                'name' => 'PrintCare',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Gampaha',
                'address' => 'Print Care PLC/ No. 77, Lunugamugoda Road, Kelaniya',
                'business_registration_number' => 'BQ75',
            ],
            [
                'name' => 'Ramya Horticulture (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Gampaha',
                'address' => 'No. 459/1, Kandy Road, Ranmuthugala, Kadawatha',
                'business_registration_number' => 'PV1486',
            ],
            [
                'name' => 'Remarko Institute of Culinary Arts',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Gampaha',
                'address' => '287/A Makola north, Makola.',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Sala Enterprises',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '81 Nugegoda Pepiliyana Srilanka',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Sankem Construction PVT LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '295 Madampitiya Road Colombo 14',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Serendib Horticulture Technologies (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 70, Perera Mawatha, Boralesgamuwa',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Siam City Cement',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'Level 25, Access Tower II, Union Place',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Sino Lanka',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'Sunlanka Towers, 1090 Sri Jayawardanapura Mawatha, Rajagiriya',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Slasscom',
                'office_type' => 'Headquater',
                'company_information' => 'Other',
                'district' => 'Colombo',
                'address' => 'Elegance 31 Queens Road, Colombo 3',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Softlogic Glomark',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No 14 De fonseka place, colombo 05',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Softlogic Holdings PLC',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No 14 De fonseka place, colombo 05',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Softlogic Restaurants PVT LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No 1, Loris Place, RA de Mel Mawatha, Colombo 04',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Sri Lanka Institute of Packaging',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'Macklam Rd, Colombo 02',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Swisstek',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '23, Narahenpita Road, Nawala',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Taj Samudra Colombo',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'Near Akarsha Jewellers, 25 Galle Face Center Rd, Colombo 30000',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Thakral Global Learning',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '1st Floor, 297, Union Place, Colombo 2',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Toyota Lanka PVT LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 337, Negombo Rd, Wattala, Sri Lanka',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Tradekem (PVT) LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 67 Old Kottawa Rd, Maharagama 10280',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Transgrow PVT LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 44/8, 1st Lane, Obahena Rd, Madiwela, Kotte, Sri Lanka',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Tudawe Brothers (PVT) LTD',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => '505/2 Elvitigala Mawatha, Colombo 00500',
                'business_registration_number' => '',
            ],
            [
                'name' => 'United Motors Lanka PLC',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 100, Hyde Park Corner, Colombo 02',
                'business_registration_number' => '',
            ],
            [
                'name' => 'United Tractor & Equipment (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 683, Negombo Road, Mabola, Wattala',
                'business_registration_number' => '',
            ],
            [
                'name' => 'V Space',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => 'No. 2B/1 De Fonseka Road, Colombo 05',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Vision Care',
                'office_type' => 'Headquater',
                'company_information' => 'Private',
                'district' => 'Colombo',
                'address' => '505 Union Place, Colombo 2',
                'business_registration_number' => '',
            ],
            [
                'name' => 'Western Infirmary (Pvt) Ltd',
                'office_type' => 'Headquater',
                'company_information' => 'Private Limited Company',
                'district' => 'Colombo',
                'address' => 'No. 218, Cotta Road, Colombo 08',
                'business_registration_number' => '',
            ],
        ];
        foreach ($companies as $company) {
            Company::create([
                'name' => $company['name'],
                'slug' => \Str::slug($company['name'], '-', 'ta'),
                'address' => $company['address'],
                'business_registration_number' => $company['business_registration_number'],
                'office_type' => getCodeIdByStringEn('office_type', $company['office_type']),
                'company_information' => getCodeIdByStringEn('company_information', $company['company_information']),
                'district_id' => District::where('name', 'ILIKE', $company["district"])->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

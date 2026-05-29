<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            ['name' => '(A) Agriculture, Hunting and Forestry', 'short_description' => 'Focused on agriculture and forestry.', 'thumbnail' => 'images/sector-thumbnails/a.png'],
            ['name' => '(I) Transport, Storage and Communications', 'short_description' => 'Involves transportation and communication industries.', 'thumbnail' => 'images/sector-thumbnails/i.png'],
            ['name' => '(L) Public Administration and Defence', 'short_description' => 'Related to public administration and defence.', 'thumbnail' => 'images/sector-thumbnails/l.png'],
            ['name' => '(N) Health and Social Work', 'short_description' => 'Covers healthcare and social work sectors.', 'thumbnail' => 'images/sector-thumbnails/n.png'],
            ['name' => '(O) Other Community, Social and Personal Service Activities', 'short_description' => 'Various social and community services.', 'thumbnail' => 'images/sector-thumbnails/o.png'],
            ['name' => '(P) Private Households with Employed Persons', 'short_description' => 'Private households employing persons.', 'thumbnail' => 'images/sector-thumbnails/p.png'],
            ['name' => '(Q) Extra- Territorial Organizations and Bodies', 'short_description' => 'International and territorial organizations.', 'thumbnail' => 'images/sector-thumbnails/q.png'],
            ['name' => '(G) Wholesale and Retail Trade', 'short_description' => 'Involves trade industries.', 'thumbnail' => 'images/sector-thumbnails/g.png'],
            ['name' => '(B) Fishing', 'short_description' => 'Focused on the fishing industry.', 'thumbnail' => 'images/sector-thumbnails/b.png'],
            ['name' => '(M) Education', 'short_description' => 'Includes educational institutions.', 'thumbnail' => 'images/sector-thumbnails/m.png'],
            ['name' => '(BCS) Common', 'short_description' => 'Common services sector.', 'thumbnail' => 'images/sector-thumbnails/bcs.png'],
            ['name' => '(C) Mining and Quarrying', 'short_description' => 'Covers mining and quarrying activities.', 'thumbnail' => 'images/sector-thumbnails/c.png'],
            ['name' => '(D) Manufacturing', 'short_description' => 'Involves manufacturing industries.', 'thumbnail' => 'images/sector-thumbnails/d.png'],
            ['name' => '(E) Electricity, Gas and Water Supply', 'short_description' => 'Utilities such as electricity, gas, and water supply.', 'thumbnail' => 'images/sector-thumbnails/e.png'],
            ['name' => '(F) Construction', 'short_description' => 'Related to the construction industry.', 'thumbnail' => 'images/sector-thumbnails/f.png'],
            ['name' => '(H) Hotel and Restaurants', 'short_description' => 'Hospitality sector covering hotels and restaurants.', 'thumbnail' => 'images/sector-thumbnails/h.png'],
            ['name' => '(J) Financial Inter-mediation', 'short_description' => 'Related to financial services.', 'thumbnail' => 'images/sector-thumbnails/j.png'],
            ['name' => '(K) Real Estate, Renting and Business Activities', 'short_description' => 'Real estate and business services.', 'thumbnail' => 'images/sector-thumbnails/k.png'],
        ];

        foreach ($sectors as $sector) {
            Sector::create([
                'name' => $sector['name'],
                'description' => '', // Add a description if needed
                'thumbnail' => $sector['thumbnail'],
                'short_description' => $sector['short_description'], // Now manually specified
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}

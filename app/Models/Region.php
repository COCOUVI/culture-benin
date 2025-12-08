<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        Region::create([
            'nom_region' => 'NIKKI',
            'description_region' => "c'est une region",
            'population' => 100000,
            'superficie' => 23340.9,
            'localisation' => "Nord Atacora"
        ]);

        Region::create([
            'nom_region' => 'Ouidah',
            'description_region' => "c'est une region",
            'population' => 100000,
            'superficie' => 23340.9,
            'localisation' => "Atlantique"
        ]);

        Region::create([
            'nom_region' => 'Parakou',
            'description_region' => "c'est une region",
            'population' => 100000,
            'superficie' => 23340.9,
            'localisation' => "Atacora"
        ]);

        Region::create([
            'nom_region' => 'TchaTou',
            'description_region' => "c'est une region",
            'population' => 100000,
            'superficie' => 23340.9,
            'localisation' => "Atacora"
        ]);
    }
}

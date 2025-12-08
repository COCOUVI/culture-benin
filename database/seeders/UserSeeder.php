<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Créer l'administrateur (id_role = 1)
        // User::create([
        //     'nom' => 'Admin',
        //     'prenom' => 'System',
        //     'sexe' => 'Masculin',
        //     'date_naissance' => '1990-01-01',
        //     'email' => 'maurice.comlan@uac.bj',
        //     'password' => Hash::make('Eneam123'),
        //     'email_verified_at' => now(),
        //     'id_role' => 4, // Admin
        //     'id_langue' => 3,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Créer le manager (id_role = 5)
//        User::create([
//            'nom' => 'Manager',
//            'prenom' => 'Platform',
//            'sexe' => 'masculin',
//            'date_naissance' => '1990-01-01',
//            'email' => 'xthedev@gmail.com',
//            'password' => Hash::make('Manager123'),
//            'email_verified_at' => now(),
//            'id_role' => 5, // Manager
//            'id_langue' =>3,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);
    }
}

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

           User::create([
             'nom' => 'Maurice',
             'prenom' => 'Comlan',
             'sexe' => 'Masculin',
             'date_naissance' => '1990-01-01',
             'email' => 'maurice.comlan@uac.bj',
             'password' => Hash::make('Eneam123'),
             'email_verified_at' => now(),
             'id_role' => 1, // Admin
             'id_langue' => 3,
             'created_at' => now(),
             'updated_at' => now(),
         ]);

        User::create([
            'nom' => 'Manager',
            'prenom' => 'Platform',
            'sexe' => 'masculin',
            'date_naissance' => '1990-01-01',
            'email' => 'xthedev@gmail.com',
            'password' => Hash::make('Manager123'),
            'email_verified_at' => now(),
            'id_role' => 2, // Manager
            'id_langue' =>3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

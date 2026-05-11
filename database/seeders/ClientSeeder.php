<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Client exemple fixe
        Client::create([
            'classement_registre' => 'REG-0001',
            'nom' => 'Alaoui',
            'prenom' => 'Yassine',
            'cin' => 'AB123456',
            'genre' => 'homme',
            'date_naissance' => '1995-06-15',
            'telephone' => '0612345678',
            'email' => 'yassine@example.com',
            'adresse' => 'Salé, Maroc',
            'type' => 'ancien',
            'is_active' => true,
            'observations' => 'Client fidèle.',
        ]);

        // 30 clients générés automatiquement
        Client::factory()->count(30)->create();
    }
}

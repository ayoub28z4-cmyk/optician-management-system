<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Admin Principal',
            'email'     => 'admin@opticienne.test',
            'password'  => 'password',
            'role'      => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name'      => 'Opticienne',
            'email'     => 'opticien@opticienne.test',
            'password'  => 'password',
            'role'      => 'opticien',
            'is_active' => true,
        ]);

        User::create([
            'name'      => 'Employe Test',
            'email'     => 'employe@opticienne.test',
            'password'  => 'password',
            'role'      => 'employe',
            'is_active' => true,
        ]);
    }
}

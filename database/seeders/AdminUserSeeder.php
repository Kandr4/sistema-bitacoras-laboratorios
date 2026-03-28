<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombre' => 'Administrador',
            'paterno' => 'Sistema',
            'materno' => 'Principal',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
            'rol' => 'Admin',
            'estado' => 1
        ]);

        User::create([
            'nombre' => 'Profesor',
            'paterno' => 'Sistema',
            'materno' => 'Principal',
            'email' => 'profesor@sistema.com',
            'password' => Hash::make('profe123'),
            'rol' => 'Profesor',
            'estado' => 1
        ]);

        User::create([
            'nombre' => 'Tecnico',
            'paterno' => 'Sistema',
            'materno' => 'Principal',
            'email' => 'tecnico@sistema.com',
            'password' => Hash::make('tecni123'),
            'rol' => 'Técnico',
            'estado' => 1
        ]);
    }
}

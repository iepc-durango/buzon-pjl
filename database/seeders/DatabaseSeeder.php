<?php

namespace Database\Seeders;

use App\Models\Destinatario;
use App\Models\Tipo;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $destinatarios = [
            ['nombre' => 'Alejandro Parra Villa', 'correo' => 'alejandro.parra@iepcdurango.mx', 'cargo' => 'Magistrado'],
            ['nombre' => 'Jorge Galo Solano García', 'correo' => 'alexparra2404@gmail.com', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Rebeca Macias Herrera', 'correo' => 'rebeca.macias@iepcdurango.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Misael Omar Vargas Ochoa', 'correo' => 'misael.vargas@iepcdurango.mx', 'cargo' => 'Magistrado']
        ];

        foreach ($destinatarios as $destinatario) {
            Destinatario::create($destinatario);
        }

        $tipos = [
            ['tipo' => 'Acuerdo'],
            ['tipo' => 'PES'],
        ];

        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('secret')
        ]);
    }
}

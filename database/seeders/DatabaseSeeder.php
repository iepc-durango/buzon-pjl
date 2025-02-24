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
           // ['nombre' => 'Jorge Galo Solano García', 'correo' => '@gmail.com', 'cargo' => 'Magistrado'],
            ['nombre' => 'Ricardo López López', 'correo' => 'correo@correo.mx', 'cargo' => 'Magistrado'],
            ['nombre' => 'Fernando Alonso Rodríguez García', 'correo' => 'fernando.rodriguez@iepcdurango.mx', 'cargo' => 'Magistrado'],
            ['nombre' => 'Irma Celeste Mata García', 'correo' => 'irma.mata@iepcdurango.mx	', 'cargo' => 'Magistrado'],
            ['nombre' => 'Jesús Lemuel Flores Hernández', 'correo' => 'jesus.flores@iepcdurango.mx', 'cargo' => 'Magistrado'],
            ['nombre' => 'Ilse Monserrat Chihuahua Núñez', 'correo' => 'ilse.chihuahua@iepcdurango.mx', 'cargo' => 'Magistrade'],
            ['nombre' => 'Clarissa Herrera Canales', 'correo' => 'clarissa.herrera@iepcdurango.mx', 'cargo' => 'Magistrada'],
            ['nombre' => 'Carlos Antonio Hernández Aldana', 'correo' => 'carlos antonio.hernández@iepcdurango.hx', 'cargo' => 'Juez Civil'],
            ['nombre' => 'Madeleine Palencia Rosales', 'correo' => 'madeleine.palencia@iepcdurango.mx', 'cargo' => 'Magistrado'],
            ['nombre' => 'Jesús Francisco Enríquez Gamero', 'correo' => 'jesús francisco.enríquez@iepcdurango.hx', 'cargo' => 'Juez Civil'],
            ['nombre' => 'Juana Garay Beltrán', 'correo' => 'juana.garay@iepcdurango.mx', 'cargo' => 'Juez Civil'],
            ['nombre' => 'Lic. Raúl Rosas Velázquez', 'correo' => 'raul.rosas@iepcdurango.mx', 'cargo' => 'Magistrado'],










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

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
        /*        $destinatarios = [
                    ['nombre' => 'Alejandro Parra Villa', 'correo' => 'alejandro.parra@iepcdurango.mx', 'cargo' => 'Magistrado'],
                    ['nombre' => 'Jorge Galo Solano García', 'correo' => 'galo.solano@iepcdurango.mx', 'cargo' => 'Magistrado'],
                    ['nombre' => 'Fernando Alonso Rodríguez García', 'correo' => 'fernando.rodriguez@iepcdurango.mx', 'cargo' => 'Magistrado'],
                    ['nombre' => 'Irma Celeste Mata García', 'correo' => 'irma.mata@iepcdurango.mx	', 'cargo' => 'Magistrado'],
                    ['nombre' => 'Jesús Lemuel Flores Hernández', 'correo' => 'jesus.flores@iepcdurango.mx', 'cargo' => 'Magistrado'],
                    ['nombre' => 'Ilse Monserrat Chihuahua Núñez', 'correo' => 'ilse.chihuahua@iepcdurango.mx', 'cargo' => 'Magistrade'],
                    ['nombre' => 'Clarissa Herrera Canales', 'correo' => 'clarissa.herrera@iepcdurango.mx', 'cargo' => 'Magistrada'],
                    ['nombre' => 'Carlos Antonio Hernández Aldana', 'correo' => 'carlos.hernandez@iepcdurango.hx', 'cargo' => 'Juez Civil'],
                    ['nombre' => 'Madeleine Palencia Rosales', 'correo' => 'madeleine.palencia@iepcdurango.mx', 'cargo' => 'Magistrado'],
                    ['nombre' => 'Jesús Francisco Enríquez Gamero', 'correo' => 'jesus.enriquez@iepcdurango.hx', 'cargo' => 'Juez Civil'],
                    ['nombre' => 'Juana Garay Beltrán', 'correo' => 'juana.garay@iepcdurango.mx', 'cargo' => 'Juez Civil'],
                    ['nombre' => 'Raúl Rosas Velázquez', 'correo' => 'raul.rosas@iepcdurango.mx', 'cargo' => 'Magistrado']
                ];*/

        $destinatarios = [
            [
                "nombre" => "ALEJANDRA ARREOLA ESTRADA",
                "correo" => "alexaestra_17@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "BRENDA LIZETTE CASTAÑEDA ACEVEDO",
                "correo" => "brendaacevedoc@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "GLORIA GUADALUPE ROMÁN GALVÁN",
                "correo" => "licgalvanromann@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            [
                "nombre" => "ILIANA ANGÉLICA SALINAS ALVARADO",
                "correo" => "ili_ss75@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "KARINA MONTELONGO GARCÍA",
                "correo" => "gk_1003@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "MARÍA MAGDALENA HERRERA ALANÍS",
                "correo" => "mmah1469@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "MIRIAM GUADALUPE ROLDÁN LANZARÍN",
                "correo" => "miriam_lanzarin@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "YESIKA LILIANA RODRÍGUEZ RAMOS",
                "correo" => "yesika.ramos.rdgz@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "ÁLVARO ALCALÁ RODRÍGUEZ",
                "correo" => "alvaroama3@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "CARLOS ENRIQUE GONZÁLEZ GUZMÁN",
                "correo" => "ceguzmanglez@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "GERARDO PÉREZ LARA",
                "correo" => "aranzalara733@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "JULIO CÉSAR DE LA GARZA PIÑA",
                "correo" => "julio.pina@ujed.mx",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "LUIS FERNANDO CORTÉS CONTRERAS",
                "correo" => "fercontre.ujed@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "MANUEL DÍAZ VALADEZ",
                "correo" => "valadezdiaz@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            [
                "nombre" => "MIGUEL ÁNGEL OROZCO QUIÑONES",
                "correo" => "miguelangelqo@hotmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            [
                "nombre" => "ERNESTINA RIVERA TERÁN",
                "correo" => "teran_rivera@hotmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            [
                "nombre" => "IRMA SELENE RODRÍGUEZ SOTO",
                "correo" => "selene.soto.pjed@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            [
                "nombre" => "KAREN MACIEL FLORES",
                "correo" => "karen.flores.maciel@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            [
                "nombre" => "ÁNGEL GERARDO SAUCEDO BONILLA",
                "correo" => "gbonilla6@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            [
                "nombre" => "JOSÉ BARRERA DURÁN",
                "correo" => "dubj2023@gmail.com",
                "cargo" => "Magistratura para el Tribunal de Justicia Penal para Adolescentes "],
            [
                "nombre" => "MARTHA ELVIA RIVAS ASTORGA",
                "correo" => "martha_astorgar@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "AMÉRICA ILIANA BAUTISTA CHÁVEZ",
                "correo" => "ame.bautista90@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "DEBORAH MÓNICA RUÍZ CERRILLO",
                "correo" => "monica_cerrillo@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "ÉRIKA MONSERRAT CISNEROS FLORES",
                "correo" => "eflores723@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "JOSELYN SILDAN REYES GASCA",
                "correo" => "josefa_923@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "LORENA ITZEL HERNÁNDEZ FERNÁNDEZ",
                "correo" => "lorenafdez1109@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "LUZ MARÍA FRANCO DE LA ROSA",
                "correo" => "luz.delarosa78@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "FERNANDA PAULETTE CASTILLO MONREAL",
                "correo" => "fernanda_monreal@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "RAMONA GISELA VILLARREAL CHAIDEZ",
                "correo" => "gisela92@icloud.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "VERÓNICA TOLEDO MOGUEL",
                "correo" => "toledo_moguel@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "YARELY OLIVERA PALMA",
                "correo" => "yarely993@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "YOLANDA MARÍA ALMAGUER MERCADO",
                "correo" => "yolandaalmague@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "HÉCTOR MANUEL SOLÍS ZARAGOZA",
                "correo" => "hectorzs@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "FERNANDO DE LA HOYA GAMERO",
                "correo" => "dr.fernandogamero@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "FRANCISCO JAVIER SOLÍS BETANCOURT",
                "correo" => "javiertrk_169@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "JAIME HERRERA MARRUFO",
                "correo" => "jaime.m.h@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "LEÓN ENRIQUE FUENTES HERNÁNDEZ",
                "correo" => "leon.hdez.f@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "MARCO ANTONIO HERNÁNDEZ AGUIRRE",
                "correo" => "marquito.aguirre@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "RAYMUNDO ALFONSO SALINAS ANDRADE",
                "correo" => "rayandrade.abogado@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Conciliación y Arbitraje"],
            [
                "nombre" => "JESÚS ANTONIO REYES TREJO",
                "correo" => "trejo070896@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "FABIOLA DEL RAYO ORTÍZ VIZCARRA",
                "correo" => "fabiolavizcarraortiz@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "YESIKA GARCÍA MANSUR",
                "correo" => "ysikmansur@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "GEOVANNE MARÍA AGÜERO VARGAS",
                "correo" => "geovannevargas27@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "GABRIEL DE JESÚS AGUILERA GONZÁLEZ",
                "correo" => "gabychuy68@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "GUSTAVO ALBERTO MUÑOZ ESCARPITA",
                "correo" => "escarpita1@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "HÉCTOR FRANCISCO GARCÍA COLON",
                "correo" => "hector.fco.hfcg@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "MARIO ALBERTO GUAJARDO GAMBOA",
                "correo" => "marioalbertogamboaguajardo@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "ÓSCAR GABRIEL MORENO MEDINA",
                "correo" => "advocatusoscarmedina@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            [
                "nombre" => "RAÚL NEZAHUALCOYOTL SEGOVIA MUÑOZ DE LEÓN",
                "correo" => "raulmdls.rgm@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"]
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

        User::factory()->create([
            'name' => 'José Lemuel Flores Hernández',
            'email' => 'jose.flores@iepcdurango.mx',
            'password' => bcrypt('uTc5724*.')
        ]);
    }
}

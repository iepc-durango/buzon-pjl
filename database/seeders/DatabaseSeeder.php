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
//        $destinatarios = [
//            ['nombre' => 'Alejandro Parra Villa', 'correo' => 'alejandro.parra@iepcdurango.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Jorge Galo Solano García', 'correo' => 'alexparra2404@gmail.com.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Fernando Alonso Rodríguez García', 'correo' => 'fernando.rodriguez@iepcdurango.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Irma Celeste Mata García', 'correo' => 'irma.mata@iepcdurango.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Jesús Lemuel Flores Hernández', 'correo' => 'jesus.flores@iepcdurango.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Ilse Monserrat Chihuahua Núñez', 'correo' => 'ilse.chihuahua@iepcdurango.mx', 'cargo' => 'Magistrade'],
//            ['nombre' => 'Clarissa Herrera Canales', 'correo' => 'clarissa.herrera@iepcdurango.mx', 'cargo' => 'Magistrada'],
//            ['nombre' => 'Carlos Antonio Hernández Aldana', 'correo' => 'carlos.hernandez@iepcdurango.mx', 'cargo' => 'Juez Civil'],
//            ['nombre' => 'Madeleine Palencia Rosales', 'correo' => 'madeleine.palencia@iepcdurango.mx', 'cargo' => 'Magistrado'],
//            ['nombre' => 'Jesús Francisco Enríquez Gamero', 'correo' => 'jesus.enriquez@iepcdurango.hx', 'cargo' => 'Juez Civil'],
//            ['nombre' => 'Juana Garay Beltrán', 'correo' => 'juana.garay@iepcdurango.mx', 'cargo' => 'Juez Civil'],
//            ['nombre' => 'Raúl Rosas Velázquez', 'correo' => 'raul.rosas@iepcdurango.mx', 'cargo' => 'Magistrado']
//        ];

        /*$destinatarios = array(
            array(
                "nombre" => "ALEJANDRA ESTRADA ARREOLA",
                "correo" => "alexaestra_17@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "BRENDA LIZETTE ACEVEDO CASTAÑEDA",
                "correo" => "brendaacevedoc@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "GLORIA GUADALUPE GALVÁN ROMÁN",
                "correo" => "licgalvanromann@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"),
            array(
                "nombre" => "ILIANA ANGÉLICA ALVARADO SALINAS",
                "correo" => "ili_ss75@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "KARINA GARCÍA MONTELONGO",
                "correo" => "gk_1003@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "MARÍA MAGDALENA ALANÍS HERRERA",
                "correo" => "mmah1469@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "MIRIAM GUADALUPE LANZARÍN ROLDÁN",
                "correo" => "miriam_lanzarin@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "YESIKA LILIANA RAMOS RODRÍGUEZ",
                "correo" => "yesika.ramos.rdgz@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "ÁLVARO RODRÍGUEZ ALCALÁ",
                "correo" => "alvaroama3@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "CARLOS ENRIQUE GUZMÁN GONZÁLEZ",
                "correo" => "ceguzmanglez@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "GERARDO LARA PÉREZ",
                "correo" => "aranzalara733@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "JULIO CÉSAR PIÑA DE LA GARZA",
                "correo" => "julio.pina@ujed.mx",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "LUIS FERNANDO CONTRERAS CORTÉS",
                "correo" => "fercontre.ujed@gmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "MANUEL VALADEZ DÍAZ",
                "correo" => "valadezdiaz@hotmail.com",
                "cargo" => "Magistraturas del Tribunal Superior de Justicia "),
            array(
                "nombre" => "MIGUEL ÁNGEL QUIÑONES OROZCO",
                "correo" => "miguelangelqo@hotmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"),
            array(
                "nombre" => "ERNESTINA TERÁN RIVERA",
                "correo" => "teran_rivera@hotmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"),
            array(
                "nombre" => "IRMA SELENE SOTO RODRÍGUEZ",
                "correo" => "selene.soto.pjed@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"),
            array(
                "nombre" => "KAREN FLORES MACIEL",
                "correo" => "karen.flores.maciel@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"),
            array(
                "nombre" => "ÁNGEL GERARDO BONILLA SAUCEDO",
                "correo" => "gbonilla6@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"),
            array(
                "nombre" => "JOSÉ DURÁN BARRERA",
                "correo" => "dubj2023@gmail.com",
                "cargo" => "Magistratura para el Tribunal de Justicia Penal para Adolescentes "),
            array(
                "nombre" => "MARTHA ELVIA ASTORGA RIVAS",
                "correo" => "martha_astorgar@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "AMÉRICA ILIANA CHÁVEZ BAUTISTA",
                "correo" => "ame.bautista90@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "DEBORAH MÓNICA CERRILLO RUÍZ",
                "correo" => "monica_cerrillo@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "ÉRIKA MONSERRAT FLORES CISNEROS",
                "correo" => "eflores723@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "JOSELYN SILDAN GASCA REYES",
                "correo" => "josefa_923@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "LORENA ITZEL FERNÁNDEZ HERNÁNDEZ",
                "correo" => "lorenafdez1109@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "LUZ MARÍA DE LA ROSA FRANCO",
                "correo" => "luz.delarosa78@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "FERNANDA PAULETTE MONREAL CASTILLO",
                "correo" => "fernanda_monreal@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "RAMONA GISELA CHAIDEZ VILLARREAL",
                "correo" => "gisela92@icloud.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "VERÓNICA MOGUEL TOLEDO",
                "correo" => "toledo_moguel@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "YARELY PALMA OLIVERA",
                "correo" => "yarely993@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "YOLANDA MARÍA MERCADO ALMAGUER",
                "correo" => "yolandaalmague@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "HÉCTOR MANUEL ZARAGOZA SOLÍS",
                "correo" => "hectorzs@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "FERNANDO GAMERO DE LA HOYA",
                "correo" => "dr.fernandogamero@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "FRANCISCO JAVIER BETANCOURT SOLÍS",
                "correo" => "javiertrk_169@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "JAIME MARRUFO HERRERA",
                "correo" => "jaime.m.h@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "LEÓN ENRIQUE HERNÁNDEZ FUENTES",
                "correo" => "leon.hdez.f@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "MARCO ANTONIO AGUIRRE HERNÁNDEZ",
                "correo" => "marquito.aguirre@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "RAYMUNDO ALFONSO ANDRADE SALINAS",
                "correo" => "rayandrade.abogado@gmail.com",
                "cargo" => "Magistraturas del Tribunal de Conciliación y Arbitraje"),
            array(
                "nombre" => "JESÚS ANTONIO TREJO REYES",
                "correo" => "trejo070896@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "FABIOLA DEL RAYO VIZCARRA ORTÍZ",
                "correo" => "fabiolavizcarraortiz@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "YESIKA MANSUR GARCÍA",
                "correo" => "ysikmansur@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "GEOVANNE MARÍA VARGAS AGÜERO",
                "correo" => "geovannevargas27@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "GABRIEL DE JESÚS GONZÁLEZ AGUILERA",
                "correo" => "gabychuy68@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "GUSTAVO ALBERTO ESCARPITA MUÑOZ",
                "correo" => "escarpita1@hotmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "HÉCTOR FRANCISCO COLON GARCÍA",
                "correo" => "hector.fco.hfcg@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "MARIO ALBERTO GAMBOA GUAJARDO",
                "correo" => "marioalbertogamboaguajardo@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "ÓSCAR GABRIEL MEDINA MORENO",
                "correo" => "advocatusoscarmedina@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras"),
            array(
                "nombre" => "RAÚL NEZAHUALCOYOTL MUÑOZ DE LEÓN SEGOVIA",
                "correo" => "raulmdls.rgm@gmail.com",
                "cargo" => "Juezas y Jueces/Personas Juzgadoras")
        );*/

        $destinatarios = [
            ["nombre" => "Lessly Jhovana Carrillo García", "correo" => "jhovanacarrillo8@gmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Alondra Gutiérrez Flores", "correo" => "alondra.gutierrez.isw@gmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "José Uriel Zamora Benitez", "correo" => "realuriel7@gmail.com", "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            ["nombre" => "José Uriel Zamora Benitez", "correo" => "uri.7amora@gmail.cpm", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Jorge Galo Solano García", "correo" => "galosola2273@gmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Jorge Galo Solano García", "correo" => "galosola@hotmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Jorge Galo Solano García", "correo" => "galo.solano@iepcdurango.mx", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Joaquín de la Cruz Pérez", "correo" => "jdlcp_12@outlook.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "José Lemuel Flores Hernández", "correo" => "joselemuelfloreshernandez@gmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "José Lemuel Flores Hernández", "correo" => "jose.flores@iepcdurango.mx", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Fernando Alonso Rodríguez García", "correo" => "farg980702@gmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Fernando Alonso Rodríguez García", "correo" => "fernando.rodriguez@iepcdurango.mx", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Madeleine Palencia Rosales", "correo" => "madeleine.159@hotmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Madeleine Palencia Rosales", "correo" => "kikaira159@gmail.com", "cargo" => "Magistraturas del Tribunal Superior de Justicia "],
            ["nombre" => "Madeleine Palencia Rosales", "correo" => "madeleine.palencia@iepcdurango.mx", "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            ["nombre" => "Irma Celeste Mata García", "correo" => "matagarciaceleste@gmail.com", "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            ["nombre" => "Irma Celeste Mata García", "correo" => "irma.cele19991@hotmail.com", "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            ["nombre" => "Irma Celeste Mata García", "correo" => "irma.mata@iepcdurango.mx", "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            ["nombre" => "Carlos Antonio Hernández Aldana", "correo" => "carlosantonioh2310@gmail.com", "cargo" => "Magistraturas del Tribunal de Disciplina Judicial"],
            ["nombre" => "Carlos Antonio Hernández Aldana", "correo" => "carlos.hernandez@iepcdurango.mx", "cargo" => "Magistratura para el Tribunal de Justicia Penal para Adolescentes "],
            ["nombre" => "Clarissa Herrera Canales", "correo" => "clarissa.herrerac07@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Clarissa Herrera Canales", "correo" => "clary_22omhc@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Clarissa Herrera Canales", "correo" => "clarissa.herrera@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Juana Garay Beltrán", "correo" => "garay780512@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Juana Garay Beltrán", "correo" => "juana.garay@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Ilse Monserrat Chihuahua Núñez", "correo" => "chihuahuanunezi@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Ilse Monserrat Chihuahua Núñez", "correo" => "ilse.chihuahua@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Jesús Francisco Enríquez Gamero", "correo" => "fm_nj@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Jesús Francisco Enríquez Gamero", "correo" => "jesus.enriquez@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Misael Omar Vargas Ochoa", "correo" => "misaelomar.1590@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Misael Omar Vargas Ochoa", "correo" => "misael.vargas@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Jorge Antonio Quiñones Alvarado", "correo" => "jorge_alvarado_1@outlook.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Jorge Antonio Quiñones Alvarado", "correo" => "joorgee_111@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Jorge Antonio Quiñones Alvarado", "correo" => "correochafa_111@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Rebeca Macías Herrera", "correo" => "herrera_rm@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Rebeca Macías Herrera", "correo" => "rebek_mc@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Rebeca Macías Herrera", "correo" => "rebeka.mahe@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Rebeca Macías Herrera", "correo" => "rebeca.macias@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Raymundo Saucedo Martínez", "correo" => "ing.raymundo.saucedo@gmail.com", "cargo" => "Magistraturas del Tribunal de Conciliación y Arbitraje"],
            ["nombre" => "Raymundo Saucedo Martínez", "correo" => "kurorailgun@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Sergio Manuel Quiñones Torres", "correo" => "smt_1806@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Sergio Manuel Quiñones Torres", "correo" => "lic.sergio.manuelqtq@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Sergio Manuel Quiñones Torres", "correo" => "sergio.quinones@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Sirena del Carmen Favela Plazola", "correo" => "sirenafavela2095@outlook.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Sirena del Carmen Favela Plazola", "correo" => "sirena.favela@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Alejandro Parra Villa", "correo" => "alexparra2404@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Alejandro Parra Villa", "correo" => "alejandro.parra@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Jesús Raymundo Hernández Hernández", "correo" => "jesus.hernandez@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Perla Lucero Arreola Escobedo", "correo" => "perla.arreola@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "José Omar Ortega Soria", "correo" => "omar.ortega@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "José Omar Ortega Soria", "correo" => "omarortegasoria@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Cristina de Guadalupe Campos Zavala", "correo" => "cristina.campos@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Ruth Alejandra Soto Medina", "correo" => "ruthsotom55@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Gala Yareli Cervantes Alvarado", "correo" => "gala_c@hotmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Gala Yareli Cervantes Alvarado", "correo" => "galita.ca@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Raúl Rosas Velázquez", "correo" => "raul.rosas@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Abril Cardoza Silerio", "correo" => "abril.cardoza@iepcdurango.mx", "cargo" => "Juezas y Jueces/Personas Juzgadoras"],
            ["nombre" => "Gerardo Barrientos Carrillo", "correo" => "geracarrillob@gmail.com", "cargo" => "Juezas y Jueces/Personas Juzgadoras"]
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

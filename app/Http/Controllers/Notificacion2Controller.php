<?php

namespace App\Http\Controllers;

use App\Models\Notificacion2;
use App\Models\Tipo;
use App\Models\Destinatarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Notificacion2Controller extends Controller
{
    public function create()
    {
        $tipos = Tipo::all();
        $destinatarios = Destinatarios::all();

        $municipios = [
            'Canatlán', 'Canelas', 'Coneto de Comonfort', 'Cuencamé', 'Durango',
            'General Simón Bolívar', 'Gómez Palacio', 'Guadalupe Victoria', 'Guanaceví',
            'Hidalgo', 'Indé', 'Lerdo', 'Mapimí', 'Mezquital', 'Nazas', 'Nombre de Dios',
            'Ocampo', 'El Oro', 'Otáez', 'Pánuco de Coronado', 'Peñón Blanco', 'Poanas',
            'Pueblo Nuevo', 'Rodeo', 'San Bernardo', 'San Dimas', 'San Juan de Guadalupe',
            'San Juan del Río', 'San Luis del Cordero', 'San Pedro del Gallo', 'Santa Clara',
            'Santiago Papasquiaro', 'Súchil', 'Tamazula', 'Tepehuanes', 'Tlahualilo', 'Topia',
            'Vicente Guerrero'
        ];

        return Inertia::render('Notificaciones/create', compact('tipos', 'destinatarios', 'municipios'));
    }


    
    public function store(Request $request)
    {
        $request->validate([
            'destinatario_id' => 'required|exists:destinatarios,id',
            'tipo_id' => 'required|exists:tipos,id',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'descripcion_fundamento' => 'nullable|string',
            'descripcion_docu' => 'nullable|string',
            'frag_doc' => 'nullable|string',
            'descripcion_notificado' => 'nullable|string',
            'sesion' => 'nullable|string|max:255',
            'no_acuerdo' => 'nullable|string|max:255',
            'denunciante' => 'nullable|string|max:255',
            'denunciado' => 'nullable|string|max:255',
            'no_expediente' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:255',
        ]);
    
        // Obtener el tipo seleccionado
        $tipo = $request->input('tipo_id');
    
        // Si es "Acuerdo", los campos de "PES" se ponen en null
        if ($tipo == 1) { // Ajusta este ID según tu base de datos
            $data = [
                'user_id' => Auth::id(),
                'destinatario_id' => $request->input('destinatario_id'),
                'tipo_id' => $tipo,
                'titulo' => $request->input('titulo'),
                'descripcion' => $request->input('descripcion'),
                'sesion' => $request->input('sesion'),
                'no_acuerdo' => $request->input('no_acuerdo'),
                // Campos de PES en null
                'denunciante' => null,
                'denunciado' => null,
                'no_expediente' => null,
                'municipio' => null,
                'descripcion_fundamento' => null,
                'descripcion_docu' => null,
                'frag_doc' => null,
                'descripcion_notificado' => null,
            ];
        } 
        // Si es "PES", los campos de "Acuerdo" se ponen en null
        else if ($tipo == 2) { // Ajusta este ID según tu base de datos
            $data = [
                'user_id' => Auth::id(),
                'destinatario_id' => $request->input('destinatario_id'),
                'tipo_id' => $tipo,
                'no_expediente' => $request->input('no_expediente'),
                'denunciante' => $request->input('denunciante'),
                'denunciado' => $request->input('denunciado'),
                'municipio' => $request->input('municipio'),
                'descripcion_fundamento' => $request->input('descripcion_fundamento'),
                'descripcion_docu' => $request->input('descripcion_docu'),
                'frag_doc' => $request->input('frag_doc'),
                'descripcion_notificado' => $request->input('descripcion_notificado'),
                // Campos de Acuerdo en null
                'titulo' => null,
                'descripcion' => null,
                'sesion' => null,
                'no_acuerdo' => null,
            ];
        }
    
        // Guardar en la base de datos
        Notificacion2::create($data);
    
        return redirect()->route('notificaciones.create')->with('success', 'Notificación creada correctamente.');
    }
    
}

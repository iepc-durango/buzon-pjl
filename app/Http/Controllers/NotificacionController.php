<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Tipo;
use App\Models\Destinatarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Importa Mail para enviar correos
use App\Mail\NotificacionMail; // Importa el Mailable

class NotificacionController extends Controller
{
    // Método para mostrar la vista de crear notificación
    public function create()
    {
        // Obtienes los tipos y destinatarios
        $tipos = Tipo::all();
        $destinatarios = Destinatarios::all();

        // Devuelves los datos a la vista de Inertia
        return inertia('Notificacion', [
            'tipos' => $tipos,
            'destinatarios' => $destinatarios,
        ]);
    }

    // Método para almacenar la nueva notificación
    public function store(Request $request)
    {
        // Verifica si el usuario está autenticado
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Validación de los datos
        $validated = $request->validate([
            'tipo_id' => 'required|exists:tipos,id',
            'destinatario_id' => 'required|exists:destinatarios,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
        ]);

        // Crear la notificación
        $notificacion = Notificacion::create([
            'tipo_id' => $validated['tipo_id'],
            'user_id' => $user->id, // Aquí usamos Auth::user()->id
            'destinatario_id' => $validated['destinatario_id'],
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'fecha' => $validated['fecha'],
        ]);

        // Obtener el destinatario por su ID
        $destinatario = Destinatarios::find($validated['destinatario_id']);

        // Si el destinatario tiene un correo electrónico (campo 'correo'), enviamos el correo
        if ($destinatario && $destinatario->correo) {
            // Enviar el correo al destinatario utilizando el campo 'correo'
            Mail::to($destinatario->correo)->send(new NotificacionMail($notificacion));
        }

        // Retornar la respuesta
        return response()->json($notificacion, 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetalleController extends Controller
{
    public function index($notificacion)
    {
        
        $detalles = Detalle::where('id_notificacion', '=', $notificacion)->get();

        return Inertia::render('Notificaciones/Detalles', [
            'detalles' => $detalles
        ]);
    }
}

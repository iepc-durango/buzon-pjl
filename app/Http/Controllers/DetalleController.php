<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetalleController extends Controller
{
    public function index($notificacion)
    {
        // Obtener los detalles con su destinatario y su folio correspondiente
        $detalles = Detalle::with(['destinatario', 'folio']) // Cargar la relación folio
            ->where('id_notificacion', $notificacion)
            ->get();

          //dd($detalles->toArray()); // Verificar si folio está presente

        return Inertia::render('Notificaciones/Detalles', [
            'detalles' => $detalles
        ]);
    }
}

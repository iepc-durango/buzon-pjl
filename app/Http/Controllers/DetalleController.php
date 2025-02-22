<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DetalleController extends Controller
{
    public function index()
    {
        
        $detalles = Detalle::all(); 

        return Inertia::render('Notificaciones/Detalles', [
            'detalles' => $detalles
        ]);
    }
}

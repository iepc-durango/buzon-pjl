<?php

namespace App\Http\Controllers;
use App\Models\Destinatarios; // Asegúrate de que tienes un modelo 'Item' para la búsqueda
use Inertia\Inertia;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Buscar en la base de datos, por ejemplo, en el modelo Item
        $results = destinatarios::where('nombre', 'like', "%$query%")->get();

        return Inertia::render('Search', [
            'results' => $results
        ]);
    }
}

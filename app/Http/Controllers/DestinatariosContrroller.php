<?php

namespace App\Http\Controllers;

use App\Models\Destinatarios;
use App\Http\Resources\DestinatarioResource;

use Illuminate\Http\Request;


class DestinatariosContrroller extends Controller
{
    public function index()
    {

        $destinatarios = DestinatarioResource::collection(Destinatarios::paginate(10));


        return inertia ('Lista/listapersonalizada', [
            'destinatarios' => $destinatarios,
        ]);
    }
}

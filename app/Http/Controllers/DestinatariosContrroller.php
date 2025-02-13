<?php

namespace App\Http\Controllers;

use App\Models\Destinatarios;
use App\Http\Resources\DestinatarioResource;
use Illuminate\Http\Request;







class DestinatariosContrroller extends Controller

{
    public function index(Request $request)

    {


        

        $destinatariosQuery = Destinatarios::query();

        $this->applySearch($destinatariosQuery, $request->search);
       $destinatarios = DestinatarioResource::collection(
        $destinatariosQuery->paginate(10)
    );
    

       //$destinatarios = DestinatarioResource::collection(Destinatarios::paginate(10));



        return inertia ('Lista/listapersonalizada', [
           'destinatarios' => $destinatarios,
           'search' => $request->search ?? '',

        ]);


       
    }


    protected function applySearch($query, $search)
    {
            return $query->when($search, function($query, $search){
                $query->where('nombre', 'like', '%'.$search.'%')
                ->orWhere('correo', 'like', '%' . $search . '%');
            });
    }



    public function getItems()
    {
        $destinatarios = Destinatarios::all();
        return response()->json($destinatarios);
    }
}

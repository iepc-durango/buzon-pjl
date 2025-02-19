<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;  // Cambia TestMail por el nombre de tu Mailable si es otro
use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Obtener el contenido del correo desde la solicitud
        $content = $request->input('content');
        
        // Usar el contenido para enviar el correo
        Mail::to('alondra.gutierrez.isw@gmail.com')->send(new TestMail($content));

        return response()->json(['message' => 'Correo enviado']);
    }
}

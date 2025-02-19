<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArchivoAdjuntoMail;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Guardar el archivo
        $archivo = $request->file('avatar');
        $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
        $rutaArchivo = $archivo->storeAs('uploads', $nombreArchivo, 'public');

        // Enviar el correo con el archivo adjunto
        $rutaCompleta = storage_path("app/public/{$rutaArchivo}");
        Mail::to('destinatario@example.com')->send(new ArchivoAdjuntoMail($rutaCompleta));

        return response()->json([
            'message' => 'Archivo subido y enviado por correo correctamente',
        ]);
    }
}

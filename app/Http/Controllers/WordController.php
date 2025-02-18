<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;




class WordController extends Controller
{
    public function generate(Request $request)
    {
        
        $validated = $request->validate([
            'titulo' => 'required|string',
            'sesion' => 'required|string',
            'nacuerdo' => 'required|string',
            'tipo' => 'required|string',
            'especificar' => 'nullable|string', 
            'resumen' => 'required|string',
        ]);

        $fecha = now()->format('d/m/Y');
      



        //rutas
        $templatePath = base_path('app/plantillas/oficio.pdf'); 

    
        $templateProcessor = new TemplateProcessor($templatePath);

        // plantilla
        $templateProcessor->setValue('titulo', $validated['titulo']);
        $templateProcessor->setValue('sesion', $validated['sesion']);
        $templateProcessor->setValue('nacuerdo', $validated['nacuerdo']);
        $templateProcessor->setValue('tipo', $validated['tipo']);
        $templateProcessor->setValue('resumen', $validated['resumen']);
        $templateProcessor->setValue('fecha', $fecha);
    
        

        if ($validated['tipo'] === 'Otro' && isset($validated['especificar'])) {
            $templateProcessor->setValue('especificar', $validated['especificar']);
        } else {
            $templateProcessor->setValue('especificar', ''); 
        }

        // Guardar el documento generado en una ubicación temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $templateProcessor->saveAs($tempFile);


        return response()->streamDownload(function () use ($tempFile) {
            readfile($tempFile);
            unlink($tempFile);
        }, 'documento_generado.docx');
    }
}

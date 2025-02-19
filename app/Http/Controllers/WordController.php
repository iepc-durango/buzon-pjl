<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

Carbon::setLocale('es');


class WordController extends Controller
{
    public function generate(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'titulo' => 'required|string',
            'sesion' => 'required|string',
            'nacuerdo' => 'required|string',
            'tipo' => 'required|string',
            'especificar' => 'nullable|string', // Especificar solo si es necesario
            'resumen' => 'required|string',
        ]);

        $fecha = now()->format('d/m/Y');
        $mes = now()->format('F'); // El mes se mostrará en español por el locale configurado previamente



        // Ruta de la plantilla
        $templatePath = storage_path('app/plantillas/oficio.docx'); // Cambia "tu_plantilla.docx" por el nombre real de la plantilla

        // Cargar la plantilla
        $templateProcessor = new TemplateProcessor($templatePath);

        // Rellenar los valores en la plantilla
        $templateProcessor->setValue('titulo', $validated['titulo']);
        $templateProcessor->setValue('sesion', $validated['sesion']);
        $templateProcessor->setValue('nacuerdo', $validated['nacuerdo']);
        $templateProcessor->setValue('tipo', $validated['tipo']);
        $templateProcessor->setValue('resumen', $validated['resumen']);
        $templateProcessor->setValue('fecha', $fecha);
        $templateProcessor->setValue('mes', $mes);
        
        // Si se especifica un tipo personalizado, asignar el valor
        if ($validated['tipo'] === 'Otro' && isset($validated['especificar'])) {
            $templateProcessor->setValue('especificar', $validated['especificar']);
        } else {
            $templateProcessor->setValue('especificar', ''); // Si no es "Otro", dejar vacío
        }

        // Guardar el documento generado en una ubicación temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $templateProcessor->saveAs($tempFile);

        // Devolver el archivo como una descarga
        return response()->streamDownload(function () use ($tempFile) {
            readfile($tempFile);
            unlink($tempFile);
        }, 'documento_generado.docx');
    }
}


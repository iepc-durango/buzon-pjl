<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use setasign\Fpdi\Fpdi;

class PdfController extends Controller
{
    public function generate(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'titulo' => 'required|string',
            'sesion' => 'required|string',
            'nacuerdo' => 'required|string',
            'tipo' => 'required|string',
            'especificar' => 'nullable|string',
        ]);

        $fecha = now()->format('d/m/Y');

        // Ruta de la plantilla PDF
        $templatePath = storage_path('app/plantillas/oficio.pdf'); // Cambia a tu plantilla en PDF

        // Crear instancia FPDI
        $pdf = new Fpdi();

        // Cargar la plantilla PDF
        $pdf->AddPage();
        $pdf->setSourceFile($templatePath);

        // Obtener la primera página de la plantilla
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);

        // Establecer la fuente
        $pdf->SetFont('Arial', '', 12);

        // Establecer posición y agregar los valores dinámicos en los campos correspondientes

        // Título
        $pdf->SetXY(50, 50); // Ajusta la posición según sea necesario
        $pdf->Write(0, $validated['titulo']);

        // Sesión
        $pdf->SetXY(50, 60); // Ajusta la posición según sea necesario
        $pdf->Write(0, $validated['sesion']);

        // No. Acuerdo
        $pdf->SetXY(50, 70); // Ajusta la posición según sea necesario
        $pdf->Write(0, $validated['nacuerdo']);

        // Tipo
        $pdf->SetXY(50, 80); // Ajusta la posición según sea necesario
        $pdf->Write(0, $validated['tipo']);

        // Especificar (si es necesario)
        if ($validated['tipo'] === 'Otro' && isset($validated['especificar'])) {
            $pdf->SetXY(50, 90); // Ajusta la posición según sea necesario
            $pdf->Write(0, $validated['especificar']);
        }

        // Fecha
        $pdf->SetXY(50, 100); // Ajusta la posición según sea necesario
        $pdf->Write(0, $fecha);

        // Guardar el archivo PDF en una ubicación temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'pdf');
        $pdf->Output('F', $tempFile . '.pdf');

        // Devolver el archivo PDF generado como una descarga
        return response()->download($tempFile . '.pdf', 'documento_generado.pdf', [
            'Content-Type' => 'application/pdf',
        ])->deleteFileAfterSend(true); // Elimina el archivo después de enviarlo
    }
}

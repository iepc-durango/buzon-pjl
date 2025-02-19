<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use \setasign\Fpdi\Fpdi;

Carbon::setLocale('es');


class WordController extends Controller
{
    public function generate(Request $request)
    {


        $pdfPath = base_path('buzon-pjl/storage/app/plantillas/oficio.pdf');
        $pdf = new Fpdi();
        // add a page
        //$pdf->AddPage();
        // set the source file
        $pdf->setSourceFile($pdfPath); //
    
        $pdf->AddPage($orientation = 'P', $size = 'Letter');
        $pdf->SetAutoPageBreak(false, 0); #pone margen
        // import page 1
        $tplIdx = $pdf->importPage(1);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useImportedPage($tplIdx);
    
        $pdf->SetFont('arial', '', '14');
    
        //$pdf->SetXY(78.2, 109.5);
        //$pdf->Write(0, 'xxxxxx');
    
        $pdf->Output();

    //     $pdfPath = storage_path('/app/plantillas/oficio.pdf'); 

    //     $pdf = new Fpdi();
    //     $pdf->AddPage();
    //     $pdf->setSourceFile($pdfPath);
    //     $tplIdx1 = $pdf->importPage(1);
    //     $pdf->useImportedPage($tplIdx1,10,10,100);
    // //$newTpl1 = $pdf->beginTemplate();
    // $pdf->SetFont("Times");
    // $pdf->SetTextColor(255,0,0);
   

    //    $pdf->SetXY(30,30);
    // $pdf->Write(5, "lorem50fdgdegz gjytyju gfjh") ;


    // //$pdf->useTemplate($newTpl1);//imprime el doc
    // return $pdf ->output(); 
  


        // Validación de los datos recibidos
        // $validated = $request->validate([
        //     'titulo' => 'required|string',
        //     'sesion' => 'required|string',
        //     'nacuerdo' => 'required|string',
        //     'tipo' => 'required|string',
        //     'especificar' => 'nullable|string', // Especificar solo si es necesario
        //     'resumen' => 'required|string',
        // ]);

        // $fecha = now()->format('d/m/Y');
        // $mes = now()->format('F'); // El mes se mostrará en español por el locale configurado previamente
    



        // // Ruta de la plantilla
        // $templatePath = storage_path('app/plantillas/oficio.pdf'); // Cambia "tu_plantilla.docx" por el nombre real de la plantilla

        // // Cargar la plantilla
        // $templateProcessor = new TemplateProcessor($templatePath);

        // // Rellenar los valores en la plantilla
        // $templateProcessor->setValue('titulo', $validated['titulo']);
        // $templateProcessor->setValue('sesion', $validated['sesion']);
        // $templateProcessor->setValue('nacuerdo', $validated['nacuerdo']);
        // $templateProcessor->setValue('tipo', $validated['tipo']);
        // $templateProcessor->setValue('resumen', $validated['resumen']);
        // $templateProcessor->setValue('fecha', $fecha);
        // $templateProcessor->setValue('mes', $mes);
        
        // // Si se especifica un tipo personalizado, asignar el valor
        // if ($validated['tipo'] === 'Otro' && isset($validated['especificar'])) {
        //     $templateProcessor->setValue('especificar', $validated['especificar']);
        // } else {
        //     $templateProcessor->setValue('especificar', ''); // Si no es "Otro", dejar vacío
        // }

        // // Guardar el documento generado en una ubicación temporal
        // //$tempFile = tempnam(sys_get_temp_dir(), 'word');
        // //$templateProcessor->saveAs($tempFile);

        // // Devolver el archivo como una descarga
        // //return response()->streamDownload(function () use ($tempFile) {
        //    // readfile($tempFile);
        //    // unlink($tempFile);
        // //}, //'documento_generado.pdf');
        // $pdf->useTemplate($newTpl1);//imprime el doc
        // $pdf ->output();
        
    }
}


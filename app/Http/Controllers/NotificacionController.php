<?php

namespace App\Http\Controllers;

use App\Mail\NotificacionMailable;
use Aws\DocDB\DocDBClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tipo;
use App\Models\Notificacion;
use App\Models\NotificacionArchivo;
use App\Models\Detalle;
use App\Models\Destinatario;
use App\Models\Folio;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Jobs\EnviarNotificacionJob;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use function Laravel\Prompts\form;
use NumberFormatter;


class NotificacionController extends Controller
{

    public function index()
    {


        //$notificaciones = Notificacion::all();


        $notificaciones = Notificacion::with('folio')->get();
        // Revisar si los datos traen el folio correctamente
        Log::info('Notificaciones con folio: ', $notificaciones->toArray());

        return Inertia::render('Index', ['notificaciones' => $notificaciones]);


    }


    // private function generarFolioParaNotificacion($notificacion)
    // {
    //     $ultimoFolio = Folio::max('folio') ?? 0;
    //     $nuevoFolio = $ultimoFolio + 1;

    //     try {
    //         $folio = Folio::create([
    //             'notificacion_id' => $notificacion->id,
    //             'folio' => $nuevoFolio,
    //         ]);

    //         Log::info('Folio generado correctamente: ' . $folio->folio);
    //         return $folio;

    //     } catch (\Exception $e) {
    //         Log::error('Error al generar el folio: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    /**
     * Genera el PDF temporalmente y guarda los datos del formulario en sesión.
     * Se espera que el front-end envíe también el campo "tipo".
     */
    public function generarPdfTemporal(Request $request)
    {
        $request->validate(['tipo_id' => 'required|exists:tipos,id', 'titulo' => 'nullable|string', 'no_acuerdo' => 'nullable|string', 'sesion' => 'nullable|string', 'descripcion' => 'nullable|string', 'fecha_aprobacion' => 'nullable|date', 'no_expediente' => 'nullable|string', 'denunciante' => 'nullable|string', 'denunciado' => 'nullable|string', 'municipio' => 'nullable|string', 'descripcion_fundamento' => 'nullable|string', 'descripcion_docu' => 'nullable|string', 'frag_doc' => 'nullable|string', 'descripcion_notificado' => 'nullable|string', 'tipo' => 'required|string',

            //Linea para adjuntar archivos

            // Puedes validar que attachments sea un arreglo de archivos
            'attachments.*' => 'nullable|file']);

        // Genera el PDF y obtiene el contenido binario
        $pdfContent = $this->generatePdf(new Request($request->all()));

        // Codifica el PDF en base64 para almacenarlo de forma segura en sesión
        $pdfContent = base64_encode($pdfContent);

        // Procesar archivos adjuntos: se guardan en carpeta temporal y su información (incluyendo el nombre original) se almacena en sesión.
        $attachmentsData = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Guarda el archivo en una carpeta temporal (por ejemplo, "temp_attachments")
                $path = $file->storeAs('temp_attachments', $file->getClientOriginalName());
                $attachmentsData[] = ['path' => $path, 'name' => $file->getClientOriginalName()];
            }
        }
        // Excluye los archivos adjuntos del request al guardarlo en sesión
        $formData = $request->except('attachments');

        Session::put('form_data', $formData);
        Session::put('pdf_data', $pdfContent);
        Session::put('attachments', $attachmentsData);//Para guardar archivos si existen


        return response()->json(['message' => 'PDF generado y guardado en sesión']);
    }

    /**
     * Genera el PDF utilizando FPDI a partir de una plantilla y devuelve su contenido binario.
     */
    public function generatePdf(Request $request)
    {
        try {


            $data = $request->except('tipo');
            $type = $request->input('tipo');

            $templatePath = storage_path('app/plantillas/' . ($type === 'Acuerdo' ? 'acuerdo_plantilla.pdf' : 'pes_plantilla.pdf'));

            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile($templatePath);
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId);


            $pdf->SetFont('Helvetica', '', 11);

            $currentDate = now()->format('Y-m-d H:i:s');
            $typeText = $type === 'Acuerdo' ? 'Acuerdo' : 'PES';

            if ($type === 'Acuerdo') {
                $pdf->SetXY(31, 96.5);
                $pdf->Cell(0, 10, $data['no_acuerdo'] ?? '', 0, 1);
                $pdf->SetXY(101, 96.8);
                $pdf->Cell(0, 10, $data['fecha_aprobacion'] ?? '', 0, 1);
                $pdf->SetXY(149, 96.5);
                $pdf->Cell(0, 10, $data['sesion'] ?? '', 0, 1);
                $pdf->SetXY(31, 115);
                $pdf->Cell(0, 10, $data['titulo'] ?? '', 0, 1);
                $pdf->SetXY(31, 154.5);
                $pdf->MultiCell(156, 4, $data['descripcion'] ?? '', 0, 1);
                $pdf->SetFont('Helvetica', 'B', 11);
                $pdf->SetXY(65, 225);
                // Establecer el idioma a español
                Carbon::setLocale('es');
                $now = Carbon::now();

                $pdf->Write(0, "Victoria de Durango, Dgo a " . now()->format('d') . " de " . $now->translatedFormat('F') . " de " . now()->format('Y'));

                // Imagen de la firma
                $pdf->Image(storage_path('app/plantillas/se_firma_sello.png'), 65, 205, 80, 0, 'PNG');


            } else if ($type === 'PES') {
                $pdf->importPage(1);

                $pdf->SetXY(130, 25);
                $pdf->Cell(0, 10, $data['tipo'] ?? '', 0, 1);
                $pdf->SetXY(130, 18);
                $pdf->Cell(0, 10, $data['no_expediente'] ?? '', 0, 1);
                $pdf->SetXY(127, 25);
                $pdf->Cell(0, 10, $data['denunciante'] ?? '', 0, 1);
                $pdf->SetXY(127, 33);
                $pdf->Cell(0, 10, $data['denunciado'] ?? '', 0, 1);
                $pdf->SetXY(20, 98);
                $pdf->Cell(0, 10, $data['municipio'] ?? '', 0, 1);
                $pdf->SetXY(20, 115);
                $pdf->MultiCell(0, 5, $data['descripcion_fundamento'] ?? '', 0, 1);
                $pdf->SetXY(20, 170);
                $pdf->MultiCell(0, 5, $data['descripcion_docu'] ?? '', 0, 1);
                $pdf->SetXY(20, 208);
                $pdf->MultiCell(0, 5, $data['frag_doc'] ?? '', 0, 1);
                setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');


                $now = Carbon::now(); 
    $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
    $diaEnLetras = ucfirst($formatter->format($now->day)); // "Doce" en lugar de "12"
    
    // Formato final de la fecha
    $textoFecha = "$diaEnLetras de " . ucfirst($now->translatedFormat('F')) . " del " . $now->format('Y');

    // Especificar la posición en el PDF y escribir la fecha
    $pdf->SetXY(65, 225);
    $pdf->Write(0, $textoFecha);

                // $dia = date('d'); // Día en número
                // $mes = strftime('%B');
                // $mes = ucfirst(strftime('%B')); // Nombre del mes con la primera letra en mayúscula
                // $anio = date('Y'); // Año


                // $pdf->SetXY(15, 98);
                // $pdf->Cell(0, 10, $dia, 0, 0, 'C'); // Día en número

                // $pdf->SetXY(115, 98);
                // $pdf->Cell(0, 10, "de", 0, 0);

                // $pdf->SetXY(70, 98);
                // $pdf->Cell(0, 10, $mes, 0, 0, 'C'); // Nombre del mes

                // $pdf->SetXY(155, 98);
                // $pdf->Cell(0, 10, "de", 0, 0);

                // $pdf->SetXY(160, 98);
                // $pdf->Cell(0, 10, $anio, 0, 0, 'C'); // Año

                $pdf->AddPage(); // Asegúrate de agregar una nueva página
                $templateId1 = $pdf->importPage(2);
                $pdf->useTemplate($templateId1);

                $pdf->SetXY(130, 18);
                $pdf->Cell(0, 10, $data['no_expediente'] ?? '', 0, 1);
                $pdf->SetXY(127, 25);
                $pdf->Cell(0, 10, $data['denunciante'] ?? '', 0, 1);
                $pdf->SetXY(127, 33);
                $pdf->Cell(0, 10, $data['denunciado'] ?? '', 0, 1);
                $pdf->SetXY(20, 55);
                $pdf->MultiCell(0, 5, $data['descripcion_notificado'] ?? '', 0, 1);


            }


            //$pdf->SetXY(10, 290);
            //$pdf->Cell(0, 10, "Tipo: $typeText - Fecha de generación: $currentDate", 0, 1, 'C');

            $pdfOutput = $pdf->Output('S');

            // Opcional: guarda el PDF en almacenamiento temporal para depuración
            $tempPdfPath = storage_path('app/temp_generated_pdf.pdf');
            file_put_contents($tempPdfPath, $pdfOutput);

            return $pdfOutput;
        } catch (\Exception $e) {
            Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el PDF.'], 500);
        }
    }

    /**
     * (Opcional) Almacena la notificación y el PDF de forma definitiva.
     */
    public function store(Request $request)
    {
        if (!Session::has('form_data') || !Session::has('pdf_data')) {
            return response()->json(['error' => 'No hay datos para guardar'], 400);
        }

        $formData = Session::get('form_data');
        $pdfContent = Session::get('pdf_data');
        // Decodifica el PDF para guardarlo en disco
        $pdfContent = base64_decode($pdfContent);

        $formData['user_id'] = Auth::id();

        $notificacion = Notificacion::create($formData);

        // Generar folio
        $this->generarFolioParaNotificacion($notificacion);


        $pdfPath = 'pdfs/notificacion_' . $notificacion->id . '.pdf';
        Storage::put($pdfPath, $pdfContent);

        // Procesa y almacena los archivos adjuntos en la base de datos
        if (Session::has('attachments')) {
            $attachmentsData = Session::get('attachments');
            foreach ($attachmentsData as $att) {
                $newPath = 'notificaciones_archivos/' . basename($att['path']);
                Storage::move($att['path'], $newPath);
                NotificacionArchivo::create(['notificacion_id' => $notificacion->id, 'file_path' => $newPath, 'file_name' => $att['name']]);
            }
        }


        Session::forget(['form_data', 'pdf_data', 'attachments']);

        return redirect()->route('notificaciones.index');
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $tipos = Tipo::all();
        $municipios = ['Canatlán', 'Canelas', 'Coneto de Comonfort', 'Cuencamé', 'Durango', 'General Simón Bolívar', 'Gómez Palacio', 'Guadalupe Victoria', 'Guanaceví', 'Hidalgo', 'Indé', 'Lerdo', 'Mapimí', 'Mezquital', 'Nazas', 'Nombre de Dios', 'Ocampo', 'El Oro', 'Otáez', 'Pánuco de Coronado', 'Peñón Blanco', 'Poanas', 'Pueblo Nuevo', 'Rodeo', 'San Bernardo', 'San Dimas', 'San Juan de Guadalupe', 'San Juan del Río', 'San Luis del Cordero', 'San Pedro del Gallo', 'Santa Clara', 'Santiago Papasquiaro', 'Súchil', 'Tamazula', 'Tepehuanes', 'Tlahualilo', 'Topia', 'Vicente Guerrero'];
        $destinatarios = Destinatario::all();

        return Inertia::render('Notificaciones/create', compact('tipos', 'municipios', 'destinatarios'));
    }

    private function generarFolioParaNotificacion($notificacion)
    {
        // Si está vacío, asigna 0

        $ultimoFolio = Folio::max('folio') ?? 0;
        $nuevoFolio = $ultimoFolio + 1;

        try {
            $folio = Folio::create(['notificacion_id' => $notificacion->id, 'folio' => $nuevoFolio,]);

            Log::info('Folio generado correctamente: ' . $folio->folio);
            return $folio;

        } catch (\Exception $e) {
            Log::error('Error al generar el folio: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Envía el correo a todos los destinatarios usando colas (Lista Global).
     * @throws PdfParserException
     * @throws PdfReaderException
     */
    public function enviarCorreoGlobal(Request $request)
    {
        if (!Session::has('form_data') || !Session::has('pdf_data')) {
            return response()->json(['error' => 'No hay datos para enviar'], 400);
        }

        $formData = Session::get('form_data');
        $tipoPlantilla = strtolower($formData['tipo']);

       

//        $pdf = $this->generatePdf(new Request($formData));

//        $pdfContentBase64 = Session::get('pdf_data');
        // Decodifica el PDF para guardarlo en disco
//        $pdfContentBinary = base64_decode($pdfContentBase64);

 

// Agregar validación para asegurarse de que el tipo de plantilla sea válido
if (!in_array($tipoPlantilla, ['acuerdo', 'pes'])) {
    // Mostrar el valor recibido para ayudar a depurar el error
    return response()->json(['error' => 'Tipo de plantilla inválido', 'received_tipo' => $tipoPlantilla], 400);
}


        $formData['user_id'] = Auth::id();


          

        if (isset($formData['tipo'])) {
            unset($formData['tipo']);
        }

        $notificacion = Notificacion::create($formData);
//        $pdfPath = 'pdfs/notificacion_' . $notificacion->id . '.pdf';
//        Storage::put($pdfPath, $pdfContentBinary);

        // Procesa y guarda los adjuntos en la BD
        $this->procesarAdjuntos($notificacion);

       

// Ruta de la plantilla PDF dependiendo del tipo (acuerdo_plantilla.pdf o pes_plantilla.pdf)
$templatePath = storage_path('app/plantillas/' . $tipoPlantilla . '_plantilla.pdf'); // 'acuerdo_plantilla.pdf' o 'pes_plantilla.pdf'

        // Path to PDF template
        //$templatePath = storage_path('app/plantillas/acuerdo_plantilla.pdf');


        $destinatarios = Destinatario::all()->toArray();

        foreach ($destinatarios as $index => $destinatario) {
//        dd($destinatario);
            // FPDI  instance
            $pdf = new Fpdi();


            // Generar un folio único para cada PDF generado
            $folio = $this->generarFolioParaNotificacion($notificacion);

            $token = Str::uuid()->toString();
            $link = route('notificacion.abrir', ['token' => $token]);

            Detalle::create(['id_notificacion' => $notificacion->id, 'destinatario_id' => $destinatario['id'], 'status_abierto' => 'UNREAD', 'status_envio' => 'send', 'link' => $link,]);

           // Importamos la plantilla PDF
           $pdf->setSourceFile($templatePath);
           $tplIdx = $pdf->importPage(1);
           $pdf->AddPage();
           $pdf->useTemplate($tplIdx, 0, 0, 215.9, 279.4); // Tamaño Carta

           // Configuración de fuente
           $pdf->SetFont('Helvetica', '', 8);
           $pdf->SetTextColor(0, 0, 0);

        // Escribir datos en el PDF según el tipo de plantilla
       if ($tipoPlantilla == 'acuerdo') {
           // Datos específicos para "acuerdo"
           $pdf->SetXY(29, 38.5);
           $pdf->Write(0, mb_convert_encoding(('C. ' . $destinatario["nombre"]), 'ISO-8859-1', 'UTF-8'));

           $pdf->SetXY(147, 28);
           $pdf->Write(0, 'IEPC/SE/BE/' . str_pad($folio->folio, 2, '0', STR_PAD_LEFT) . '/2025');

           $pdf->SetFont('Helvetica', '', 11);
           
           $pdf->SetXY(31, 102);
           $pdf->Write(0, $formData['no_acuerdo']);
           $pdf->SetXY(101, 102);
           $pdf->Write(0, Carbon::create($formData['fecha_aprobacion'])->format('d/m/Y'));
           $pdf->SetXY(149, 102);
           $pdf->Write(0, $formData['sesion']);
           $pdf->SetXY(31, 115);
           $pdf->MultiCell(150, 4, mb_convert_encoding($formData['titulo'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(31, 154.5);
           $pdf->MultiCell(150, 4, mb_convert_encoding($formData['descripcion'], 'ISO-8859-1', 'UTF-8'));
           $now = Carbon::now();
           $pdf->SetXY(65, 225);
           $pdf->Write(0, "Victoria de Durango, Dgo a " . now()->format('d') . " de " . $now->translatedFormat('F') . " de " . now()->format('Y'));
           $pdf->Image(storage_path('app/plantillas/se_firma_sello.png'), 65, 205, 80, 0, 'PNG');
       } elseif ($tipoPlantilla == 'pes') {
           // Datos específicos para "pes"
           $pdf->SetXY(35, 61);
           $pdf->Write(0, mb_convert_encoding(('C. ' . $destinatario["nombre"]), 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(33, 65);
           $pdf->Write(0, mb_convert_encoding(($destinatario["cargo"]), 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(124, 13.5);
           $pdf->Cell(0, 10, mb_convert_encoding($formData['no_expediente'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(126, 19);
           $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciante'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(127, 25);
           $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciado'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(20, 92);
           $pdf->MultiCell(175, 4, mb_convert_encoding($formData['descripcion_fundamento'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(19, 137.5);
           $pdf->MultiCell(175, 4, mb_convert_encoding($formData['descripcion_docu'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(20, 168);
           $pdf->MultiCell(175.3, 4, mb_convert_encoding($formData['frag_doc'], 'ISO-8859-1', 'UTF-8'));

           $now = Carbon::now(); 
           $now->locale('es');
           $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
           $diaEnLetras = ucfirst($formatter->format($now->day)); 
            $pdf->SetXY(20, 82);
            $pdf->Write(0, mb_convert_encoding($formData['municipio'], 'ISO-8859-1', 'UTF-8')  .  '        Durango,              a              ' . $diaEnLetras . '                      de                       ' . ucfirst($now->translatedFormat('F')) . '                            de                         ' . now()->format('Y'));





           $pdf->AddPage(); // Agregar segunda página para PES
           $tplIdx = $pdf->importPage(2); // Importamos la segunda página de la plantilla
           $pdf->useTemplate($tplIdx, 0, 0); // Usamos las dimensiones correspondientes


           $pdf->SetXY(124, 18);
           $pdf->Cell(0, 10, mb_convert_encoding($formData['no_expediente'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(126, 25);
           $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciante'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(125, 33);
           $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciado'], 'ISO-8859-1', 'UTF-8'));
           $pdf->SetXY(20, 53);
           $pdf->MultiCell(175.3, 4, mb_convert_encoding($formData['descripcion_notificado'], 'ISO-8859-1', 'UTF-8'));

       }

            // Path to save the generated PDF
            $outputPath = storage_path('IEPC-SE-BE-' . $folio->folio . '_' . $notificacion->id . '_' . time() . '.pdf');

            // Save the PDF to the disk
            $pdf->Output($outputPath, 'F', true);

            Log::info('Despachando trabajo de envío de notificación para: ' . $destinatario["correo"]);
            Mail::mailer('ses')->to($destinatario["correo"])->queue(new NotificacionMailable($outputPath, $link));
            Log::info('Trabajo de envío de notificación despachado para: ' . $destinatario["correo"]);
//            dispatch(new \App\Jobs\EnviarNotificacionJob($destinatario["correo"], $outputPath, $link))->delay(now()->addSeconds(5));
        }

        Session::forget(['form_data', 'pdf_data']);


        return response()->json(['message' => 'Correos globales en proceso de envío.']);
    }

    /**
     * Procesa los archivos adjuntos guardados en sesión y crea los registros en la BD.
     */
    private function procesarAdjuntos(Notificacion $notificacion)
    {
        if (Session::has('attachments')) {
            $attachmentsData = Session::get('attachments');
            // Retornar archivo como descarga a manera de prueba...
            foreach ($attachmentsData as $index => $att) {
                $fileName = $att['name'];
                $path = 'BUZONPOPJL2025/N' . mb_str_pad($notificacion->id, '3', '0', STR_PAD_LEFT) . '/' . $fileName;
                $file = Storage::get($att['path']);
                // Guarda el archivo en AWS S3
                Storage::disk('s3')->put($path, $file);
                // Elimina el archivo de la carpeta temporal
                Storage::delete($att['path']);
                // Crea el registro
                NotificacionArchivo::create(['notificacion_id' => $notificacion->id, 'file_path' => $path, 'file_name' => $att['name']]);
            }
        }
    }

    /**
     * Envía el correo a los destinatarios seleccionados (Lista Personalizada) usando colas.
     */
    public function enviarCorreoPersonalizado(Request $request)
    {
        $request->validate(['destinatarios' => 'required|array|min:1']);

        if (!Session::has('form_data')) {
            return response()->json(['error' => 'No hay datos para enviar'], 400);
        }

        $selectedDestIds = $request->input('destinatarios');
        $formData = Session::get('form_data');
        $tipoPlantilla = strtolower($formData['tipo']);


         // Agregar validación para asegurarse de que el tipo de plantilla sea válido
         if (!in_array($tipoPlantilla, ['acuerdo', 'pes'])) {
            // Mostrar el valor recibido para ayudar a depurar el error
            return response()->json(['error' => 'Tipo de plantilla inválido', 'received_tipo' => $tipoPlantilla], 400);
        }

        $formData['user_id'] = Auth::id();
        if (isset($formData['tipo'])) {
            unset($formData['tipo']);
        }

        $notificacion = Notificacion::create($formData);


        $this->procesarAdjuntos($notificacion);

        // Establecemos la ruta de la plantilla según el tipo (acuerdo o pes)
   // Ruta de la plantilla PDF dependiendo del tipo (acuerdo_plantilla.pdf o pes_plantilla.pdf)
   $templatePath = storage_path('app/plantillas/' . $tipoPlantilla . '_plantilla.pdf'); // 'acuerdo_plantilla.pdf' o 'pes_plantilla.pdf'

        // Ruta de la plantilla PDF
        //$templatePath = storage_path('app/plantillas/acuerdo_plantilla.pdf');

        $destinatarios = Destinatario::whereIn('id', $selectedDestIds)->get();


        foreach ($destinatarios as $index => $destinatario) {
            // Instancia de FPDI para modificar el PDF
            $pdf = new Fpdi();

            // Generar un folio único para cada PDF generado
            $folio = $this->generarFolioParaNotificacion($notificacion);


            $token = Str::uuid()->toString();
            $link = route('notificacion.abrir', ['token' => $token]);

            Detalle::create(['id_notificacion' => $notificacion->id, 'destinatario_id' => $destinatario->id, 'status_abierto' => 'UNREAD', 'status_envio' => 'send', 'link' => $link,]);

            // Importamos la plantilla PDF
            $pdf->setSourceFile($templatePath);
            $tplIdx = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx, 0, 0, 215.9, 279.4); // Tamaño Carta

            // Configuración de fuente
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetTextColor(0, 0, 0);

         // Escribir datos en el PDF según el tipo de plantilla
        if ($tipoPlantilla == 'acuerdo') {
            // Datos específicos para "acuerdo"
            $pdf->SetXY(29, 38.5);
            $pdf->Write(0, mb_convert_encoding('C. '. $destinatario->nombre, 'ISO-8859-1', 'UTF-8'));

            $pdf->SetXY(147, 28);
            $pdf->Write(0, 'IEPC/SE/BE/' . str_pad($folio->folio, 2, '0', STR_PAD_LEFT) . '/2025');

            $pdf->SetFont('Helvetica', '', 11);
            
            $pdf->SetXY(31, 102);
            $pdf->Write(0, $formData['no_acuerdo']);
            $pdf->SetXY(101, 102);
            $pdf->Write(0, Carbon::create($formData['fecha_aprobacion'])->format('d/m/Y'));
            $pdf->SetXY(149, 102);
            $pdf->Write(0, $formData['sesion']);
            $pdf->SetXY(31, 115);
            $pdf->MultiCell(150, 4, mb_convert_encoding($formData['titulo'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(31, 154.5);
            $pdf->MultiCell(150, 4, mb_convert_encoding($formData['descripcion'], 'ISO-8859-1', 'UTF-8'));
            $now = Carbon::now();
            $pdf->SetXY(65, 225);
            $pdf->Write(0, "Victoria de Durango, Dgo a " . now()->format('d') . " de " . $now->translatedFormat('F') . " de " . now()->format('Y'));
            $pdf->Image(storage_path('app/plantillas/se_firma_sello.png'), 65, 205, 80, 0, 'PNG');
        } elseif ($tipoPlantilla == 'pes') {
            // Datos específicos para "pes"
            $pdf->SetXY(35, 61);
            $pdf->Write(0, mb_convert_encoding($destinatario->nombre, 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(33, 65);
            $pdf->Write(0, mb_convert_encoding($destinatario->cargo, 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(124, 13.5);
            $pdf->Cell(0, 10, mb_convert_encoding($formData['no_expediente'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(126, 19);
            $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciante'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(127, 25);
            $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciado'], 'ISO-8859-1', 'UTF-8'));
            // $pdf->SetXY(20, 78);
            // $pdf->Cell(0, 10, mb_convert_encoding($formData['municipio'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(20, 92);
            $pdf->MultiCell(175, 4, mb_convert_encoding($formData['descripcion_fundamento'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(19, 137.5);
            $pdf->MultiCell(175, 4, mb_convert_encoding($formData['descripcion_docu'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(20, 168);
            $pdf->MultiCell(175.3, 4, mb_convert_encoding($formData['frag_doc'], 'ISO-8859-1', 'UTF-8'));

            $now = Carbon::now(); 
            $now->locale('es');
            $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
            $diaEnLetras = ucfirst($formatter->format($now->day)); 
             $pdf->SetXY(20, 82);
             $pdf->Write(0, mb_convert_encoding($formData['municipio'], 'ISO-8859-1', 'UTF-8')  .  '        Durango,              a              ' . $diaEnLetras . '                      de                       ' . ucfirst($now->translatedFormat('F')) . '                            de                         ' . now()->format('Y'));
 


            $pdf->AddPage(); // Agregar segunda página para PES
            $tplIdx = $pdf->importPage(2); // Importamos la segunda página de la plantilla
            $pdf->useTemplate($tplIdx, 0, 0); // Usamos las dimensiones correspondientes


            $pdf->SetXY(124, 18);
            $pdf->Cell(0, 10, mb_convert_encoding($formData['no_expediente'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(126, 25);
            $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciante'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(125, 33);
            $pdf->Cell(0, 10, mb_convert_encoding($formData['denunciado'], 'ISO-8859-1', 'UTF-8'));
            $pdf->SetXY(20, 53);
            $pdf->MultiCell(175.3, 4, mb_convert_encoding($formData['descripcion_notificado'], 'ISO-8859-1', 'UTF-8'));

        }


            // Guardar PDF generado
            $outputPath = storage_path('app/public/IEPC-SE-BE-' . $folio->folio . '_' . $notificacion->id . '_' . time() . '.pdf');
            $pdf->Output($outputPath, 'F');

            // Envío de correo
            Mail::mailer('ses')->to($destinatario->correo)->queue(new NotificacionMailable($outputPath, $link));
//            dispatch(new \App\Jobs\EnviarNotificacionJob($destinatario->correo, $outputPath, $link))->delay(now()->addSeconds(5));
        }

        // Limpiar la sesión después de enviar los correos
        Session::forget(['form_data', 'pdf_data']);

        return response()->json(['message' => 'Correos personalizados en proceso de envío.']);
    }

    /**
     * Actualiza el estado a 'READ' cuando el destinatario hace clic en el enlace.
     */
    public function abrirNotificacion($token)
    {
        $expectedLink = route('notificacion.abrir', ['token' => $token]);
        //$detalle = Detalle::where('link', $expectedLink)->firstOrFail();

        $detalle = Detalle::with('notificacion.archivos')->where('link', $expectedLink)->firstOrFail();
        $detalle->update(['status_abierto' => 'READ']);
        return view('notificaciones.abierto', compact('detalle'));
    }

    public function descargarArchivo(NotificacionArchivo $archivo)
    {
        if (!Storage::exists($archivo->file_path)) {
            abort(404);
        }
        return Storage::download($archivo->file_path, $archivo->file_name);
    }


}

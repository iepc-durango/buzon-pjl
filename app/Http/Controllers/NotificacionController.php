<?php

namespace App\Http\Controllers;

use App\Mail\NotificacionMailable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tipo;
use App\Models\Notificacion;
use App\Models\NotificacionArchivo;
use App\Models\Detalle;
use App\Models\Destinatario;
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

class NotificacionController extends Controller
{

    public function index()
    {

        $notificaciones = Notificacion::all();

        return Inertia::render('Index', [
            'notificaciones' => $notificaciones
        ]);
    }

    /**
     * Genera el PDF temporalmente y guarda los datos del formulario en sesión.
     * Se espera que el front-end envíe también el campo "tipo".
     */
    public function generarPdfTemporal(Request $request)
    {
        $request->validate([
            'tipo_id' => 'required|exists:tipos,id',
            'titulo' => 'nullable|string',
            'no_acuerdo' => 'nullable|string',
            'sesion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'fecha_aprobacion' => 'nullable|date',
            'no_expediente' => 'nullable|string',
            'denunciante' => 'nullable|string',
            'denunciado' => 'nullable|string',
            'municipio' => 'nullable|string',
            'descripcion_fundamento' => 'nullable|string',
            'descripcion_docu' => 'nullable|string',
            'frag_doc' => 'nullable|string',
            'descripcion_notificado' => 'nullable|string',
            'tipo' => 'required|string',

            //Linea para adjuntar archivos

            // Puedes validar que attachments sea un arreglo de archivos
            'attachments.*' => 'nullable|file'
        ]);

        // Genera el PDF y obtiene el contenido binario
        $pdfContent = $this->generatePdf(new Request($request->all()));

        // Codifica el PDF en base64 para almacenarlo de forma segura en sesión
        $pdfContent = base64_encode($pdfContent);

        // Procesar archivos adjuntos: se guardan en carpeta temporal y su información (incluyendo el nombre original) se almacena en sesión.
        $attachmentsData = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Guarda el archivo en una carpeta temporal (por ejemplo, "temp_attachments")
                $path = $file->store('temp_attachments');
                $attachmentsData[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName()
                ];
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

            $templatePath = storage_path('app/plantillas/' . ($type === 'Acuerdo' ? 'acuerdo_plantilla.pdf' : 'PES.pdf'));

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

                $dia = date('d'); // Día en número
                $mes = strftime('%B');
                $mes = ucfirst(strftime('%B')); // Nombre del mes con la primera letra en mayúscula
                $anio = date('Y'); // Año


                $pdf->SetXY(15, 98);
                $pdf->Cell(0, 10, $dia, 0, 0, 'C'); // Día en número

                $pdf->SetXY(115, 98);
                $pdf->Cell(0, 10, "de", 0, 0);

                $pdf->SetXY(70, 98);
                $pdf->Cell(0, 10, $mes, 0, 0, 'C'); // Nombre del mes

                $pdf->SetXY(155, 98);
                $pdf->Cell(0, 10, "de", 0, 0);

                $pdf->SetXY(160, 98);
                $pdf->Cell(0, 10, $anio, 0, 0, 'C'); // Año

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
        $pdfPath = 'pdfs/notificacion_' . $notificacion->id . '.pdf';
        Storage::put($pdfPath, $pdfContent);

        // Procesa y almacena los archivos adjuntos en la base de datos
        if (Session::has('attachments')) {
            $attachmentsData = Session::get('attachments');
            foreach ($attachmentsData as $att) {
                $newPath = 'notificaciones_archivos/' . basename($att['path']);
                Storage::move($att['path'], $newPath);
                NotificacionArchivo::create([
                    'notificacion_id' => $notificacion->id,
                    'file_path' => $newPath,
                    'file_name' => $att['name']
                ]);
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
        $municipios = [
            'Canatlán', 'Canelas', 'Coneto de Comonfort', 'Cuencamé', 'Durango',
            'General Simón Bolívar', 'Gómez Palacio', 'Guadalupe Victoria', 'Guanaceví',
            'Hidalgo', 'Indé', 'Lerdo', 'Mapimí', 'Mezquital', 'Nazas', 'Nombre de Dios',
            'Ocampo', 'El Oro', 'Otáez', 'Pánuco de Coronado', 'Peñón Blanco', 'Poanas',
            'Pueblo Nuevo', 'Rodeo', 'San Bernardo', 'San Dimas', 'San Juan de Guadalupe',
            'San Juan del Río', 'San Luis del Cordero', 'San Pedro del Gallo', 'Santa Clara',
            'Santiago Papasquiaro', 'Súchil', 'Tamazula', 'Tepehuanes', 'Tlahualilo', 'Topia',
            'Vicente Guerrero'
        ];
        $destinatarios = Destinatario::all();

        return Inertia::render('Notificaciones/create', compact('tipos', 'municipios', 'destinatarios'));
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

//        $pdf = $this->generatePdf(new Request($formData));

//        $pdfContentBase64 = Session::get('pdf_data');
        // Decodifica el PDF para guardarlo en disco
//        $pdfContentBinary = base64_decode($pdfContentBase64);

        $formData['user_id'] = Auth::id();

        if (isset($formData['tipo'])) {
            unset($formData['tipo']);
        }

        $notificacion = Notificacion::create($formData);
//        $pdfPath = 'pdfs/notificacion_' . $notificacion->id . '.pdf';
//        Storage::put($pdfPath, $pdfContentBinary);

        // Procesa y guarda los adjuntos en la BD
        $this->procesarAdjuntos($notificacion);


        // Path to PDF template
        $templatePath = storage_path('app/plantillas/acuerdo_plantilla.pdf');


        $destinatarios = Destinatario::all()->toArray();

        foreach ($destinatarios as $index => $destinatario) {
//        dd($destinatario);
            // FPDI  instance
            $pdf = new Fpdi();

            $token = Str::uuid()->toString();
            $link = route('notificacion.abrir', ['token' => $token]);

            Detalle::create([
                'id_notificacion' => $notificacion->id,
                'destinatario_id' => $destinatario['id'],
                'status_abierto' => 'UNREAD',
                'status_envio' => 'send',
                'link' => $link,
            ]);

            // Set template and get pages count
            $pdf->setSourceFile($templatePath);
            // Import the first page of the template
            $tplIdx = $pdf->importPage(1);

            // Add a page to the document and use the imported template
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx, 0, 0, 215.9, 279.4); // 215.9 mm hoja Carta

            // Write the text over the template
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->SetTextColor(0, 0, 0);

            // Recipient
            $pdf->SetXY(29, 38.5);
            $pdf->Write(0, mb_convert_encoding(($destinatario["nombre"]), 'ISO-8859-1', 'UTF-8'));

            $pdf->SetFont('Helvetica', '', 11, true);;
            $pdf->SetXY(31, 102);
            $pdf->Write(0, $formData['no_acuerdo']);

            $pdf->SetXY(101, 102);
//        $pdf->Write(0, $request->information['approved_date']);
            $pdf->Write(0, Carbon::create($formData['fecha_aprobacion'])->format('d/m/Y'));

            $pdf->SetXY(149, 102);
            $pdf->Write(0, $formData['sesion']);

            $pdf->SetXY(31, 115);
            $pdf->MultiCell(150, 4, mb_convert_encoding($formData['titulo'], 'ISO-8859-1', 'UTF-8'));

            $pdf->SetXY(31, 154.5);
            $pdf->MultiCell(150, 4, mb_convert_encoding($formData['descripcion'], 'ISO-8859-1', 'UTF-8'));

            // Lugar y fecha en el siguiente formato: Victoria de Durango, Dgo a {día} de {mes de {año}
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->SetXY(65, 225);
            // Establecer el idioma a español
            Carbon::setLocale('es');
            $now = Carbon::now();

            $pdf->Write(0, "Victoria de Durango, Dgo a " . now()->format('d') . " de " . $now->translatedFormat('F') . " de " . now()->format('Y'));

            // Imagen de la firma
            $pdf->Image(storage_path('app/plantillas/se_firma_sello.png'), 65, 205, 80, 0, 'PNG');

            // Path to save the generated PDF
            $outputPath = storage_path('app/public/generated_' . $index . '.pdf');

            // Save the PDF to the disk
            $pdf->Output($outputPath, 'F', true);


            $attachmentsData = Session::get('attachments', []);

            // Enviamos el correo pasando el PDF en base64 para evitar problemas de JSON
//            dispatch(new EnviarNotificacionJob($destinatario, $pdfContentBase64, $link));
            //Mail::mailer('ses')->to($destinatario['correo'])->queue(new NotificacionMailable($destinatario, $outputPath, $link));

            Mail::mailer('ses')->to($destinatario['correo'])
                ->queue(new NotificacionMailable(
                    base64_encode(file_get_contents($outputPath)),
                    $link,
                    $attachmentsData
                ));
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
            foreach ($attachmentsData as $att) {
                $fileName = $att['name'];
                $path = 'BUZONPOPJL2025/N' . mb_str_pad($notificacion->id, '3', '0', STR_PAD_LEFT) . '/' . $fileName;
                $file = Storage::get($attachmentsData[0]['path']);
                // Guarda el archivo en AWS S3
                Storage::disk('s3')->put($path, $file);
                // Elimina el archivo de la carpeta temporal
                Storage::delete($attachmentsData[0]['path']);
//                $newPath = 'notificaciones_archivos/' . basename($att['path']);
//                Storage::move($att['path'], $newPath);
                NotificacionArchivo::create([
                    'notificacion_id' => $notificacion->id,
                    'file_path' => $path,
                    'file_name' => $att['name']
                ]);
            }
        }
    }

    /**
     * Envía el correo a los destinatarios seleccionados (Lista Personalizada) usando colas.
     */
    public function enviarCorreoPersonalizado(Request $request)
    {
        $request->validate([
            'destinatarios' => 'required|array|min:1'
        ]);
    
        if (!Session::has('form_data')) {
            return response()->json(['error' => 'No hay datos para enviar'], 400);
        }
    
        $selectedDestIds = $request->input('destinatarios');
        $formData = Session::get('form_data');
    
        $formData['user_id'] = Auth::id();
        if (isset($formData['tipo'])) {
            unset($formData['tipo']);
        }
    
        $notificacion = Notificacion::create($formData);
    
        // Ruta de la plantilla PDF
        $templatePath = storage_path('app/plantillas/acuerdo_plantilla.pdf');
    
        $destinatarios = Destinatario::whereIn('id', $selectedDestIds)->get();
    
        foreach ($destinatarios as $index => $destinatario) {
            // Instancia de FPDI para modificar el PDF
            $pdf = new Fpdi();
            $token = Str::uuid()->toString();
            $link = route('notificacion.abrir', ['token' => $token]);
    
            Detalle::create([
                'id_notificacion' => $notificacion->id,
                'destinatario_id' => $destinatario->id,
                'status_abierto' => 'UNREAD',
                'status_envio' => 'send',
                'link' => $link,
            ]);
    
            // Importamos la plantilla PDF
            $pdf->setSourceFile($templatePath);
            $tplIdx = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($tplIdx, 0, 0, 215.9, 279.4); // Tamaño Carta
    
            // Configuración de fuente
            $pdf->SetFont('Helvetica', 'B', 11);
            $pdf->SetTextColor(0, 0, 0);
    
            // Escribir datos en el PDF
            $pdf->SetXY(29, 38.5);
            $pdf->Write(0, mb_convert_encoding($destinatario->nombre, 'ISO-8859-1', 'UTF-8'));
    
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
    
            // Lugar y fecha
            Carbon::setLocale('es');
            $now = Carbon::now();
            $pdf->SetXY(65, 225);
            $pdf->Write(0, "Victoria de Durango, Dgo a " . now()->format('d') . " de " . $now->translatedFormat('F') . " de " . now()->format('Y'));
    
            // Agregar firma y sello
            $pdf->Image(storage_path('app/plantillas/se_firma_sello.png'), 65, 205, 80, 0, 'PNG');
    
            // Guardar PDF generado
            $outputPath = storage_path('app/public/generated_'.$notificacion->id.'_'.$destinatario->id.'.pdf');
            $pdf->Output($outputPath, 'F');
    
            // Envío de correo
            $attachmentsData = Session::get('attachments', []);
            Mail::mailer('ses')->to($destinatario->correo)->queue(new NotificacionMailable($outputPath, $link, $attachmentsData));
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

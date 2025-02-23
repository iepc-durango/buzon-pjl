<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use App\Models\Notificacion;
use App\Models\Detalle;
use App\Models\Destinatario;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Jobs\EnviarNotificacionJob;

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
     * Genera el PDF temporalmente y guarda los datos del formulario en sesión.
     * Se espera que el front-end envíe también el campo "tipo".
     */
    public function generarPdfTemporal(Request $request)
    {
        $request->validate([
            'tipo_id'                => 'required|exists:tipos,id',
            'titulo'                 => 'nullable|string',
            'no_acuerdo'             => 'nullable|string',
            'sesion'                 => 'nullable|string',
            'descripcion'            => 'nullable|string',
            'fecha_aprobacion'       => 'nullable|date',
            'no_expediente'          => 'nullable|string',
            'denunciante'            => 'nullable|string',
            'denunciado'             => 'nullable|string',
            'municipio'              => 'nullable|string',
            'descripcion_fundamento' => 'nullable|string',
            'descripcion_docu'       => 'nullable|string',
            'frag_doc'               => 'nullable|string',
            'descripcion_notificado' => 'nullable|string',
            'tipo'                   => 'required|string'
        ]);

        // Genera el PDF y obtiene el contenido binario
        $pdfContent = $this->generatePdf(new Request($request->all()));

        // Codifica el PDF en base64 para almacenarlo de forma segura en sesión
        $pdfContent = base64_encode($pdfContent);

        Session::put('form_data', $request->all());
        Session::put('pdf_data', $pdfContent);

        return response()->json(['message' => 'PDF generado y guardado en sesión']);
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

        Session::forget(['form_data', 'pdf_data']);

        return redirect()->route('notificaciones.index');
    }

    /**
     * Genera el PDF utilizando FPDI a partir de una plantilla y devuelve su contenido binario.
     */
    public function generatePdf(Request $request)
    {
        try {
            $data = $request->except('tipo');
            $type = $request->input('tipo');

            $templatePath = storage_path('app/plantillas/' . ($type === 'Acuerdo' ? 'Acuerdo2.pdf' : 'PES.pdf'));

            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile($templatePath);
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId);

            $pdf->SetFont('Helvetica', '', 12);

            $currentDate = now()->format('Y-m-d H:i:s');
            $typeText = $type === 'Acuerdo' ? 'Acuerdo' : 'PES';

            if ($type === 'Acuerdo') {
                $pdf->SetXY(50, 40);
                $pdf->Cell(0, 10, $data['no_acuerdo'] ?? '', 0, 1);
                $pdf->SetXY(50, 50);
                $pdf->Cell(0, 10, $data['fecha_aprobacion'] ?? '', 0, 1);
                $pdf->SetXY(50, 60);
                $pdf->Cell(0, 10, $data['sesion'] ?? '', 0, 1);
                $pdf->SetXY(50, 70);
                $pdf->Cell(0, 10, $data['titulo'] ?? '', 0, 1);
                $pdf->SetXY(50, 80);
                $pdf->MultiCell(0, 10, $data['descripcion'] ?? '', 0, 1);
            } else if ($type === 'PES') {
                $pdf->SetXY(10, 10);
                $pdf->Cell(0, 10, $data['no_expediente'] ?? '', 0, 1);
            }

            $pdf->SetXY(10, 290);
            $pdf->Cell(0, 10, "Tipo: $typeText - Fecha de generación: $currentDate", 0, 1, 'C');

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
     * Envía el correo a todos los destinatarios usando colas (Lista Global).
     */
    public function enviarCorreoGlobal(Request $request)
    {
        if (!Session::has('form_data') || !Session::has('pdf_data')) {
            return response()->json(['error' => 'No hay datos para enviar'], 400);
        }
        
        $formData = Session::get('form_data');
        $pdfContentBase64 = Session::get('pdf_data');
        // Decodifica el PDF para guardarlo en disco
        $pdfContentBinary = base64_decode($pdfContentBase64);

        $formData['user_id'] = Auth::id();

        if (isset($formData['tipo'])) {
            unset($formData['tipo']);
        }

        $notificacion = Notificacion::create($formData);
        $pdfPath = 'pdfs/notificacion_' . $notificacion->id . '.pdf';
        Storage::put($pdfPath, $pdfContentBinary);

        $destinatarios = Destinatario::all();

        foreach ($destinatarios as $destinatario) {
            $token = Str::uuid()->toString();
            $link = route('notificacion.abrir', ['token' => $token]);

            Detalle::create([
                'id_notificacion' => $notificacion->id,
                'destinatario_id' => $destinatario->id,
                'status_abierto'  => 'UNREAD',
                'status_envio'    => 'send',
                'link'            => $link,
            ]);

            // Enviamos el correo pasando el PDF en base64 para evitar problemas de JSON
            dispatch(new EnviarNotificacionJob($destinatario, $pdfContentBase64, $link));
        }

        Session::forget(['form_data', 'pdf_data']);

        return response()->json(['message' => 'Correos globales en proceso de envío.']);
    }

    /**
     * Envía el correo a los destinatarios seleccionados (Lista Personalizada) usando colas.
     */
    public function enviarCorreoPersonalizado(Request $request)
    {
        $request->validate([
            'destinatarios' => 'required|array|min:1'
        ]);

        if (!Session::has('form_data') || !Session::has('pdf_data')) {
            return response()->json(['error' => 'No hay datos para enviar'], 400);
        }
        
        $selectedDestIds = $request->input('destinatarios');
        $formData = Session::get('form_data');
        $pdfContentBase64 = Session::get('pdf_data');
        $pdfContentBinary = base64_decode($pdfContentBase64);

        $formData['user_id'] = Auth::id();
        if (isset($formData['tipo'])) {
            unset($formData['tipo']);
        }

        $notificacion = Notificacion::create($formData);
        $pdfPath = 'pdfs/notificacion_' . $notificacion->id . '.pdf';
        Storage::put($pdfPath, $pdfContentBinary);

        $destinatarios = Destinatario::whereIn('id', $selectedDestIds)->get();

        foreach ($destinatarios as $destinatario) {
            $token = Str::uuid()->toString();
            $link = route('notificacion.abrir', ['token' => $token]);

            Detalle::create([
                'id_notificacion' => $notificacion->id,
                'destinatario_id' => $destinatario->id,
                'status_abierto'  => 'UNREAD',
                'status_envio'    => 'send',
                'link'            => $link,
            ]);

            dispatch(new EnviarNotificacionJob($destinatario, $pdfContentBase64, $link));
        }

        Session::forget(['form_data', 'pdf_data']);

        return response()->json(['message' => 'Correos personalizados en proceso de envío.']);
    }

    /**
     * Actualiza el estado a 'READ' cuando el destinatario hace clic en el enlace.
     */
    public function abrirNotificacion($token)
    {
        $expectedLink = route('notificacion.abrir', ['token' => $token]);
        $detalle = Detalle::where('link', $expectedLink)->firstOrFail();
        $detalle->update(['status_abierto' => 'READ']);
        return view('notificaciones.abierto', compact('detalle'));
    }
}

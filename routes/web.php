<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\DetalleController;
use App\Models\Destinatario;
use App\Models\Notificacion;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});;

//Route::inertia('/listapersonalizada', 'ListaPersonalizada');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::post('/generate-pdf', [NotificacionController::class, 'generatePdf'])->name('notificaciones.generatePdf');

    Route::get('/detalles/{notificacion}', [DetalleController::class, 'index'])->name('detalles.index');

    Route::get('/notificaciones/create', [NotificacionController::class, 'create'])->name('notificaciones.create');
    Route::post('/notificaciones/generar-pdf-temporal', [NotificacionController::class, 'generarPdfTemporal'])->name('notificaciones.generarPdfTemporal');
    Route::post('/notificaciones/store', [NotificacionController::class, 'store'])->name('notificaciones.store');
    Route::post('/notificaciones/enviar-correo-global', [NotificacionController::class, 'enviarCorreoGlobal'])->name('notificaciones.enviarCorreoGlobal');
    Route::post('/notificaciones/enviar-correo-personalizado', [NotificacionController::class, 'enviarCorreoPersonalizado'])->name('notificaciones.enviarCorreoPersonalizado');

    Route::get('/test-mail', [NotificacionController::class, 'testSendMail']);

    // Ruta para la vista personalizada, pasando la lista de destinatarios
    Route::get('/notificaciones/personalizada', function () {
        $destinatarios = Destinatario::all();
        return Inertia::render('Notificaciones/Personalizada', compact('destinatarios'));
    })->name('notificaciones.personalizada');

    Route::get('/', function () {
        $notificaciones = Notificacion::all();
        return Inertia::render('Index', [
            'notificaciones' => $notificaciones,
        ]);
    })->name('index');


    Route::get('notificaciones/descargar/{archivo}', [NotificacionController::class, 'descargarArchivo'])
        ->name('notificaciones.download');
});

Route::get('/notificacion/abrir/{token}', [NotificacionController::class, 'abrirNotificacion'])->name('notificacion.abrir');









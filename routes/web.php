<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NotificacionController;










Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);

    
});

Route::inertia('/formdoc', 'FormDoc');

Route::inertia('/detalles', 'Detalles');

//Route::inertia('/listapersonalizada', 'ListaPersonalizada');





Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //Route::resource('destinatarios', DestinatariosContrroller::class);

    //Route::get('/api/items', [DestinatariosContrroller::class, 'getItems']);




    //Route::get('/notificaciones/create', [NotificacionController::class, 'create'])->name('notificaciones.create');
Route::post('/notificaciones', [NotificacionController::class, 'store'])->name('notificaciones.store');

Route::post('/generate-pdf', [NotificacionController::class, 'generatePdf'])->name('notificaciones.generatePdf');




//Route::post('/notificaciones/generar-pdf-temporal', [NotificacionController::class, 'generarPdfTemporal'])->name('notificaciones.generarPdfTemporal');
//Route::post('/notificaciones/store', [NotificacionController::class, 'store'])->name('notificaciones.store');
//Route::post('/notificaciones/enviar-correo-global', [NotificacionController::class, 'enviarCorreoGlobal'])->name('notificaciones.enviarCorreoGlobal');




// Ruta para el enlace único en el correo que actualiza el estado a 'READ'
//Route::get('/notificacion/abrir/{token}', [NotificacionController::class, 'abrirNotificacion'])->name('notificacion.abrir');


Route::get('/notificaciones/create', [NotificacionController::class, 'create'])->name('notificaciones.create');
Route::post('/notificaciones/generar-pdf-temporal', [NotificacionController::class, 'generarPdfTemporal'])->name('notificaciones.generarPdfTemporal');
Route::post('/notificaciones/store', [NotificacionController::class, 'store'])->name('notificaciones.store');
Route::post('/notificaciones/enviar-correo-global', [NotificacionController::class, 'enviarCorreoGlobal'])->name('notificaciones.enviarCorreoGlobal');
Route::get('/notificacion/abrir/{token}', [NotificacionController::class, 'abrirNotificacion'])->name('notificacion.abrir');



Route::get('/test-mail', [NotificacionController::class, 'testSendMail']);
    


});

//ruta para generar documento

//Route::inertia('/formdoc3', 'FormDoc3');
//Route::inertia('/formdoc4', 'FormDoc4');



//Route::middleware(['auth'])->get('/notificaciones/create', [NotificacionController::class, 'create'])->name('notificaciones.create');

// Ruta para almacenar la nueva notificación
//Route::middleware(['auth'])->post('/notificaciones', [NotificacionController::class, 'store'])->name('notificaciones.store');


//Ruta para generar word

//Route::get('/generate-document', [WordController::class, 'generate'])->name('generate.document');




//Route::middleware(['auth'])->get('/notificaciones2/create', [Notificacion2Controller::class, 'create'])->name('notificaciones.create');

// Ruta para almacenar la nueva notificación
//Route::middleware(['auth'])->post('/notificaciones2', [Notificacion2Controller::class, 'store'])->name('notificaciones.store');


 




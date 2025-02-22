<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\DetalleController;











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

    
   

Route::post('/generate-pdf', [NotificacionController::class, 'generatePdf'])->name('notificaciones.generatePdf');


//Mostrar la vista de notificaciones


Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
Route::get('/detalles', [DetalleController::class, 'index'])->name('detalles.index');





Route::get('/notificaciones/create', [NotificacionController::class, 'create'])->name('notificaciones.create');
Route::post('/notificaciones/generar-pdf-temporal', [NotificacionController::class, 'generarPdfTemporal'])->name('notificaciones.generarPdfTemporal');
Route::post('/notificaciones/store', [NotificacionController::class, 'store'])->name('notificaciones.store');
Route::post('/notificaciones/enviar-correo-global', [NotificacionController::class, 'enviarCorreoGlobal'])->name('notificaciones.enviarCorreoGlobal');
Route::get('/notificacion/abrir/{token}', [NotificacionController::class, 'abrirNotificacion'])->name('notificacion.abrir');



Route::get('/test-mail', [NotificacionController::class, 'testSendMail']);



});




 




<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DestinatariosContrroller;





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

    Route::resource('destinatarios', DestinatariosContrroller::class);

    Route::get('/api/items', [DestinatariosContrroller::class, 'getItems']);

   


});






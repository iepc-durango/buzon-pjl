<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\WordController;





use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::post('/send-email', [EmailController::class, 'sendEmail']);

Route::post('/generate-document', [WordController::class, 'generate'])->name('generate.document');





Route::inertia('/formdoc', 'FormDoc');
Route::inertia('/formdoc3', 'FormDoc3');
Route::inertia('/listapersonalizada', 'ListaPersonalizada');
Route::inertia('/listapersonalizada2', 'ListaPersonalizada2');
Route::inertia('/detalles', 'Detalles');
Route::inertia('/useform', 'useForm');
Route::inertia('/form', 'Form');
Route::inertia('/form3', 'Form3');
Route::inertia('/mail', 'Mail');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

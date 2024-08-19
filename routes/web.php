<?php

use App\Http\Controllers\tarjetas_credito;
use App\Http\Controllers\Users;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::post('/registrar', [Users::class,'crear_usuario'])->name('registrar');
/** TARJETA DE CREDITO **/
Route::get('/TDC/index',[tarjetas_credito::class,'index'])->name('TDC');
Route::post('/TDC/registrar_TDC',[tarjetas_credito::class,'registrar_TDC'])->name('registrar_TDC');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

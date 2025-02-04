<?php

use App\Http\Controllers\purchase_registry;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    /** TARJETA DE CREDITO **/
    Route::get('/TDC/index',[tarjetas_credito::class,'index'])->name('tdc.index');
    Route::put('/TDC/actualizar/{id}', [tarjetas_credito::class, 'actualizar_tdc'])->name('tdc.actualizar');

    Route::post('/TDC/registrar_TDC',[tarjetas_credito::class,'registrar_TDC'])->name('tdc.registrar');
    Route::delete('TDC/eliminar/{id}',[tarjetas_credito::class,'eliminar_tdc'])->name('tdc.eliminar');

    /** REGISTRO DE COMPRAS **/
    Route::get('/registro_compras/index',[purchase_registry::class,'index'])->name('pr.index');
    Route::put('/registro_compras/update',[purchase_registry::class,'update_registry'])->name('pr.update');
});

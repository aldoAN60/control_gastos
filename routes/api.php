<?php

use App\Http\Controllers\purchase_registry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = $request->user();

    // Genera un token personal
    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/register_purchase/index',[purchase_registry::class,'index']);
    Route::get('/registro_compras/index',[purchase_registry::class,'index'])->name('pr.index');
    Route::post('/register_purchase/post',[purchase_registry::class,'register_purchase']);
    Route::get('/test',[purchase_registry::class,'test_belogs']);
    Route::put('/registro_compras/update',[purchase_registry::class,'update_registry'])->name('pr.update');
});




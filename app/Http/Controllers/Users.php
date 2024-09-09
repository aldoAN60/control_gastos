<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Inertia\Inertia;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crear_usuario(Request $request)
    {
        $valores = $request->validate([
            'nombre' => 'required|string|max:255|min:3',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Hashear la contraseña antes de guardar
        $valores['password'] = bcrypt($valores['password']);
    
        // Crear el usuario
        User::create([
            'nombre' => $valores['nombre'],
            'apellido_paterno' => $valores['apellido_paterno'],
            'apellido_materno' => $valores['apellido_materno'],
            'email' => $valores['email'],
            'password' => $valores['password'],
        ]);
    
        // Redirigir al usuario a la página de login después de crear la cuenta
        return redirect()->route('login');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

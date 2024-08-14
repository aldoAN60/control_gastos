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
        $userModel = new User();
        $valores = $request->validate([
            'nombre' => 'required|string|max:255|min:3',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]); 

        $crear_usuario = $userModel->crear_usuario($valores);
        if (!$crear_usuario){
        //return redirect()->route('register')->withErrors(['error' => 'No se pudo crear el usuario. Por favor, inténtalo de nuevo.']);
            $mensaje = 'No se pudo crear el usuario. Por favor, inténtalo de nuevo.';
            return redirect()->route('register',['data' => $mensaje]); //<- por si ya nada mas jala
        }
        $data['exito'] = $crear_usuario;
    
        return redirect()->route('login')->with('data', $data);
    }

    public function prueba(){
        return view('login');
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

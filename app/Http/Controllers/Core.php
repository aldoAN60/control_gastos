<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class Core extends Controller
{
     // Método común para manejar la validación de respuestas
    protected function responseValidationError($message, $source)
    {
        if($source == 'API') {
            return response()->json([
                'message' => $message,
                'source' => $source
            ]);
        } else {
            return back()->withErrors($message)->withInput();
        }
    }

     // Método común para enviar respuestas tanto para la API como para la web
    protected function response($response, $source, $route = null)
    {
        if ($source == 'API') {
            return response()->json($response);
        } else {
            return redirect()->route($route)->with('data', $response);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class Core extends Controller
{
     // Método común para manejar la validación de respuestas
    protected function responseValidationError($message, $source = 'web')
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
    protected function delete_row($model, $id, $kind_delete = 'soft')
    {
        $record = $model::findOrFail($id);
    
        if ($kind_delete === 'soft') { 
            // Soft delete: marca el registro como eliminado
            $record->update(['delete' => 1]);
        }
    
        if ($kind_delete === 'hard') { 
            // Hard delete: eliminación permanente
            $record->delete();
        }
    }
    protected function updateOrCreateRecord($model, $idKey, &$data, $errorMessage)
    {
        if (!empty($data[$idKey])) {
            $record = $model::findOrFail($data[$idKey]);
            if (!$record->update($data)) {
                return ['success' => false, 'message' => $errorMessage, 'severity' => 'error'];
            }
        } else {
            $record = $model::create($data);
            if (!$record) {
                return ['success' => false, 'message' => $errorMessage, 'severity' => 'error'];
            }
            $data[$idKey] = $record->id; // Guardar el ID generado
        }

        return null; // Sin errores
    }
}

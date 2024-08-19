<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
class Validaciones
{
    public static function tdc($data)
    {
        $resultado = [];
        $rules = [
            'banco_id' => 'required|integer|exists:bancos,id',
            'alias' => 'required|string|max:20|min:5',
            'limite_credito' => 'nullable|numeric|min:0',
            'fecha_corte.number' => 'required|integer|min:1|max:30',
            'fecha_pago.number' => 'required|integer|min:1|max:30',
        ];

        $messages = [
            'banco_id.required' => 'Selecciona un banco.',
            'alias.required' => 'El alias es necesario.',
            'alias.min' => 'El alias debe tener al menos 5 caracteres.',
            'limite_credito.numeric' => 'El límite de crédito debe ser un número válido.',
            'limite_credito.min' => 'El límite de crédito no puede ser negativo.',
            'fecha_corte.number.number' => 'El día de corte debe estar entre 1 y 30.',
            'fecha_pago.number.number' => 'El día de pago debe estar entre 1 y 30.',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $resultado['exito'] = false;
            $resultado['mensajes'] = $validator->errors();
            return $resultado;
        }
        $resultado['exito'] = true;
        $resultado['data'] = $validator->validated();
        return $resultado;
    }
}

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
            'fecha_corte' => 'required|integer|min:1|max:31',
            'fecha_pago' => 'required|integer|min:1|max:31',
        ];

        $messages = [
            'banco_id.required' => 'Selecciona un banco.',
            'alias.required' => 'El alias es necesario.',
            'alias.min' => 'El alias debe tener al menos 5 caracteres.',
            'limite_credito.numeric' => 'El límite de crédito debe ser un número válido.',
            'limite_credito.min' => 'El límite de crédito no puede ser negativo.',
            'fecha_corte.required' => 'Selecciona el día en que se realiza el corte de tu tarjeta.',
            'fecha_pago.required' => 'Selecciona el día en que debes realizar el pago de tu tarjeta.',
            'fecha_corte' => 'El día de corte debe estar dentro del rango del 1 al 31. Selecciona un valor válido.',
            'fecha_pago' => 'El día de pago debe estar dentro del rango del 1 al 31. Selecciona un valor válido.',
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
    public static function purchase_registry_validation($data){
        $result = [];

        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            'tdc_id' => 'nullable|integer|exists:tdc,id',
            'concepto' => 'required|string|max:24|min:4|regex:/^[a-zA-Z0-9\s]+$/',
            'monto' => 'required|numeric|min:1',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'sub_categoria_id' => 'required|integer|exists:categorias,id',
            'tipo_gasto' => 'required|string|in:necesario,secundario,precindible',
            'metodo_pago_id' => 'required|integer|exists:metodo_pago,id',
            'registro_compras_frecuentes_id' => 'nullable|integer,exists:registro_compras_frecuentes,id',
            'registro_compras_credito_id' => 'nullable|integer,exists:registro_compras_credito,id',
            'eliminado' => 'nullable|boolean',
        ];

        $messages = [
            'user_id.required' => 'El campo usuario es obligatorio.',
            'user_id.integer' => 'El ID del usuario debe ser un número.',
            'user_id.exists' => 'El usuario seleccionado no existe en la base de datos.',
        
            'tdc_id.integer' => 'El ID de la tarjeta debe ser un número.',
            'tdc_id.exists' => 'La tarjeta seleccionada no existe en la base de datos.',
        
            'concepto.required' => 'El concepto es obligatorio.',
            'concepto.string' => 'El concepto debe ser una cadena de texto.',
            'concepto.max' => 'El concepto no puede tener más de 24 caracteres.',
            'concepto.min' => 'El concepto debe tener al menos 4 caracteres.',
            'concepto.regex' => 'El concepto solo puede contener letras, números y espacios.',
        
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número válido.',
            'monto.min' => 'El monto debe ser mayor o igual a 1.',
        
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.integer' => 'El ID de la categoría debe ser un número.',
            'categoria_id.exists' => 'La categoría seleccionada no existe en la base de datos.',
        
            'sub_categoria_id.integer' => 'El ID de la subcategoría debe ser un número.',
            'sub_categoria_id.exists' => 'La subcategoría seleccionada no existe en la base de datos.',
        
            'tipo_gasto.required' => 'El tipo de gasto es obligatorio.',
            'tipo_gasto.string' => 'El tipo de gasto debe ser una cadena de texto.',
            'tipo_gasto.in' => 'El tipo de gasto debe ser necesario, secundario o prescindible.',
        
            'metodo_pago_id.required' => 'El método de pago es obligatorio.',
            'metodo_pago_id.integer' => 'El ID del método de pago debe ser un número.',
            'metodo_pago_id.exists' => 'El método de pago seleccionado no existe en la base de datos.',
        
            'registro_compras_frecuentes_id.integer' => 'El ID del registro frecuente debe ser un número.',
            'registro_compras_frecuentes_id.exists' => 'El registro frecuente seleccionado no existe en la base de datos.',
            // 'registro_compras_frecuentes_id.required_without' => 'Debe seleccionar un registro frecuente si no seleccionó un registro de crédito.',
        
            'registro_compras_credito_id.integer' => 'El ID del registro de crédito debe ser un número.',
            'registro_compras_credito_id.exists' => 'El registro de crédito seleccionado no existe en la base de datos.',
            // 'registro_compras_credito_id.required_without' => 'Debe seleccionar un registro de crédito si no seleccionó un registro frecuente.',
        
            'eliminado.boolean' => 'El valor de eliminado debe ser verdadero o falso.',
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $result['success'] = false;
            $result['message'] = $validator->errors();
            return $result;
        }
        $result['success'] = true;
        $result['message'] = $validator->validated();
        return $result;
    }
}

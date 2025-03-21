<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class Validaciones
{
    public static function tdc($data)
    {
        $resultado = [];
        $rules = [
            'bank_id' => 'required|integer|exists:banks,id',
            'alias' => 'required|string|max:20|min:5',
            'credit_limit' => 'nullable|numeric|min:0',
            'statement_date' => 'required|integer|min:1|max:31',
            'payment_date' => 'required|integer|min:1|max:31',
        ];

        $messages = [
            'bank_id.required' => 'Selecciona un banco.',
            'alias.required' => 'El alias es necesario.',
            'alias.min' => 'El alias debe tener al menos 5 caracteres.',
            'credit_limit.numeric' => 'El límite de crédito debe ser un número válido.',
            'credit_limit.min' => 'El límite de crédito no puede ser negativo.',
            'statement_date.required' => 'Selecciona el día en que se realiza el corte de tu tarjeta.',
            'payment_date.required' => 'Selecciona el día en que debes realizar el pago de tu tarjeta.',
            'statement_date' => 'El día de corte debe estar dentro del rango del 1 al 31. Selecciona un valor válido.',
            'payment_date' => 'El día de pago debe estar dentro del rango del 1 al 31. Selecciona un valor válido.',
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
            'tdc_id' => [
                            'nullable',
                            'integer',
                            'exists:tdc,id',
                            Rule::requiredIf($data['payment_method_id'] == 1),
                        ],
            'concept' => 'required|string|max:24|min:4|regex:/^[a-zA-Z0-9\s]+$/',
            'amount' => 'required|numeric|min:1',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:categories,id',
            'spend_type' => 'required|string|in:necesario,secundario,precindible',
            'payment_method_id' => 'required|integer|exists:payment_method,id',
            'purchase_registry_frequent_id' => 'nullable|integer|exists:purchase_registry_frequent,id',
            'purchase_registry_credit_id' => 'nullable|integer|exists:purchase_registry_credit,id',
            'delete' => 'nullable|boolean',
        ];

        $messages = [
            'user_id.required' => 'El campo usuario es obligatorio.',
            'user_id.integer' => 'El ID del usuario debe ser un número.',
            'user_id.exists' => 'El usuario seleccionado no existe en la base de datos.',
        
            'tdc_id.integer' => 'La tarjeta de credito es obligatoria.',
            'tdc_id.exists' => 'La tarjeta seleccionada no existe en la base de datos.',
            'tdc_id.required' => 'La tarjeta de credito es obligatoria.',
            
            'concept.required' => 'El concepto es obligatorio.',
            'concept.string' => 'El concepto debe ser una cadena de texto.',
            'concept.max' => 'El concepto no puede tener más de 24 caracteres.',
            'concept.min' => 'El concepto debe tener al menos 4 caracteres.',
            'concept.regex' => 'El concepto solo puede contener letras, números y espacios.',
        
            'amount.required' => 'El monto es obligatorio.',
            'amount.numeric' => 'El monto debe ser un número válido.',
            'amount.min' => 'El monto debe ser mayor o igual a 1.',
        
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.integer' => 'El ID de la categoría debe ser un número.',
            'category_id.exists' => 'La categoría seleccionada no existe en la base de datos.',
        
            'sub_category_id.integer' => 'El ID de la subcategoría debe ser un número.',
            'sub_category_id.exists' => 'La subcategoría seleccionada no existe en la base de datos.',
        
            'spend_type.required' => 'El tipo de gasto es obligatorio.',
            'spend_type.string' => 'El tipo de gasto debe ser una cadena de texto.',
            'spend_type.in' => 'El tipo de gasto debe ser necesario, secundario o prescindible.',
        
            'payment_method_id.required' => 'El método de pago es obligatorio.',
            'payment_method_id.integer' => 'El ID del método de pago debe ser un número.',
            'payment_method_id.exists' => 'El método de pago seleccionado no existe en la base de datos.',
        
            'purchase_registry_frequent_id.integer' => 'El ID del registro frecuente debe ser un número.',
            'purchase_registry_frequent_id.exists' => 'El registro frecuente seleccionado no existe en la base de datos.',
            // 'registro_compras_frecuentes_id.required_without' => 'Debe seleccionar un registro frecuente si no seleccionó un registro de crédito.',
        
            'purchase_registry_credit_id.integer' => 'El ID del registro de crédito debe ser un número.',
            'purchase_registry_credit_id.exists' => 'El registro de crédito seleccionado no existe en la base de datos.',
            // 'registro_compras_credito_id.required_without' => 'Debe seleccionar un registro de crédito si no seleccionó un registro frecuente.',
        
            'delete.boolean' => 'El valor de eliminado debe ser verdadero o falso.',
        ];

            if ($data['is_credit'] === 1) {
                $rules = array_merge($rules, [
                    'credit_payment_frequency_id' => 'required|integer|exists:payment_frequency,id',
                    'qty_payment' => 'required|integer|min:1',
                    'remain_payment' => [
                                        'required',
                                        'integer',
                                        'min:1',
                                        "lte:qty_payment"
                                    ],
                ]);
        
            $messages = array_merge($messages, [
                'credit_payment_frequency_id.required' => 'La frecuencia de pago es obligatoria.',
                'credit_payment_frequency_id.exists' => 'La frecuencia de pago seleccionada no es válida.',
        
                'qty_payment.required' => 'La cantidad de pagos totales es obligatoria.',
                'qty_payment.integer' => 'La cantidad de pagos totales debe ser un número entero.',
                'qty_payment.min' => 'La cantidad de pagos totales no puede ser negativo.',
                
                'remain_payment.required' => 'El número de pagos restantes es obligatorio.',
                'remain_payment.integer' => 'El número de pagos restantes debe ser un número entero.',
                'remain_payment.min' => 'El número de pagos restantes no puede ser negativo.',
                'remain_payment.lte' => 'El nùmero de pagos restantes no puede ser mayor a la cantidad de pagos totales'

            ]);
        }
        
        if ($data['is_frequent'] === 1) {
            $rules = array_merge($rules, [
                'frequent_payment_frequency_id' => 'required|integer|exists:payment_frequency,id',
                'next_insert_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            ]);
        
            $messages = array_merge($messages, [
                'frequent_payment_frequency_id.required' => 'La frecuencia de pago es obligatoria.',
                'frequent_payment_frequency_id.exists' => 'La frecuencia de pago seleccionada no es válida.',

                'next_insert_date.required' => 'La próxima fecha de inserción es obligatoria.',
                'next_insert_date.date_format' => 'La fecha debe estar en el formato YYYY-MM-DD.',
                'next_insert_date.after_or_equal' => 'La fecha de inserción debe ser hoy o una fecha futura.',
            ]);
        }
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

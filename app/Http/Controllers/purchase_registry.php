<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Core;

use App\Models\category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\purchase_registry as PR;
use App\Services\Validaciones;
use App\Models\payment_frequency;
use App\Models\payment_method;
use App\Models\purchase_registry_credit;
use App\Models\purchase_registry_frequent;
use App\Models\tarjeta_credito;


class purchase_registry extends Core
{
    protected $validaciones;
    public function __construct(Validaciones $validaciones){
        $this->validaciones = $validaciones;
    }
    public function index()
    {
        $registries = PR::PurchaseRegistry()->get();
        $pr = PR::format_registries($registries);
        $categories = category::get_categories();
        $payment_frequency = payment_frequency::select('id','frequency','days')->orderBy('days')->get();
        $payment_method = payment_method::all();
        
        $props = [
            'purchase_registries' => $pr, // Asegúrate que el nombre es 'purchase_registries'
            'categories' => $categories,
            'payment_frequency' => $payment_frequency,
            'payment_method' => $payment_method,
        ]; 
        return response()->json($props);
        return inertia::render('purchase_registry/index', $props);
    }

    public function register_purchase(Request $request){
        $data = $request->all();
        
        if($request->is('api/*')) {
            $source = 'API';
        } else {
            $source = 'WEB';
        }

        if(empty($data['user_id'])){
            $data['user_id'] = auth()->user()->id;
        }

        $validation_result = $this->validaciones->purchase_registry_validation($data);
        
        if (!$validation_result['success']) {
            if($source == 'API'){
                return response()->json([
                    'success' => false,
                    'message' => $validation_result['message'],
                    'source' => $source,
                ]);
            }else{
                return back()->withErrors($validation_result['message'])->withInput();
            }
        }
        $registry = PR::create($data);

        if(!empty($registry)){

            return response()->json([
                'success' => true,
                'message' => 'Operación exitosa',
                'response' => [
                    'registry' => $registry,
                ],
                'source' => $source,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'no se envio ningun dato',
                'source' => $source,
            ]);
        }
    }

    public function update_registry(Request $request)
    {

        $source = $request->is('api/*') ? 'API' : 'WEB';
        $data = PR::format_registries_put($request->all());
        // Validación
        $validation_result = $this->validaciones->purchase_registry_validation($data);
        if (!$validation_result['success']) {
            return $this->responseValidationError($validation_result['message'], $source);
        }
    
        // Actualización del registro
        try {
            $registry = PR::findOrFail($data['id']);
            $registry->update($data);

            
            // Guardar y manejar la respuesta
            $response = $registry->save() 
                ? ['success' => true, 'message' => '¡Registro actualizado correctamente!', 'severity' => 'success'] 
                : ['success' => false, 'message' => 'No se pudo actualizar el registro, por favor inténtelo más tarde', 'severity' => 'error'];
    
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error inesperado al actualizar el registro', 'severity' => 'error'];
        }
        $route = 'pr.index';
        return $this->response( $response, $source, $route);
    }
}

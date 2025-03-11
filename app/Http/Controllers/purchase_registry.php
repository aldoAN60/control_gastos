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
use App\Models\purchase_registry_credit as prc;
use App\Models\purchase_registry_frequent as prf;
use App\Models\tarjeta_credito;


class purchase_registry extends Core
{
    protected $validaciones;
    protected $purchase_cases = [
        '10' => "is_credit",
        '01' => "is_frequent",
        '11' => "both",
        '00' => "none"
    ];
    public function __construct(Validaciones $validaciones){
        $this->validaciones = $validaciones;
    }
    public function index()
    {
        return Inertia::render('purchase_registry/index', [
            'purchase_registries' => fn () => PR::format_registries(PR::PurchaseRegistry()->get()),
            'categories' => category::get_categories(),
            'payment_frequency' => payment_frequency::select('id','frequency','days')->orderBy('days')->get(),
            'payment_method' => payment_method::all(),
            'tdc' => tarjeta_credito::get_tarjetas(),
            'spend_type' => array_values(config('app.spend_type'))
        ]);
    }

    public function register_purchase(Request $request){
        $data = $request->all();
        
        if($request->is(patterns: 'api/*')) {
            $source = 'API';
        } else {
            $source = 'WEB';
        }
        
        $case = $this->purchase_cases["{$data['is_credit']}{$data['is_frequent']}"] ?? "none";
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


        if(empty($data['user_id'])){
            $data['user_id'] = auth()->user()->id;
        }
        switch ($case) {
            case 'is_credit':
                    $prc = prc::create($data);
                    $data['purchase_registry_credit_id'] = $prc->id;
                break;

                case 'is_frequent':
                    $prf = prf::create($data);
                    $data['purchase_registry_frequent_id'] = $prf->id;
                break;

            case 'both':
                    $prc = prc::create($data);
                    $prf = prf::create($data);
                    $data['purchase_registry_credit_id'] = $prc->id;
                    $data['purchase_registry_frequent_id'] = $prf->id;
                break;
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
        return to_route('pr.index')->with('data', $response);

    }
}

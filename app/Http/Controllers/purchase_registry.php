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
            'purchase_registries' => fn () => PR::format_registries(PR::PurchaseRegistry()->orderBy('created_at', 'desc')->get()),
            'categories' => category::get_categories(),
            'payment_frequency' => payment_frequency::select('id','frequency','days')->orderBy('days')->get(),
            'payment_method' => payment_method::all(),
            'tdc' => tarjeta_credito::get_tarjetas(),
            'spend_type' => array_values(config('app.spend_type'))
        ]);
    }

    public function register_purchase(Request $request){
        $data = $request->all();
        
        if(empty($data['user_id'])){
            $data['user_id'] = auth()->user()->id;
        }
        $data['is_credit'] = (int)$data['is_credit'];
        $data['is_frequent'] = (int)$data['is_frequent'];
        $case = $this->purchase_cases["{$data['is_credit']}{$data['is_frequent']}"] ?? "none";
        $validation_result = $this->validaciones->purchase_registry_validation($data);
        
        if (!$validation_result['success']) {
            return back()->withErrors($validation_result['message'])->withInput();
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

        $response = [
            'success' => !empty($registry),
            'message' => !empty($registry) ? 'registro creado exitosamente' : 'error al crear el registro',
            'severity' => !empty($registry) ? 'success' : 'error',
            'response' => [
                'registry' => $registry
            ],
        ];
        
        return to_route('pr.index')->with('data', $response);
        
    }

    
    public function update_registry(Request $request)
    {

        $data = $request->all();
        if(empty($data['user_id'])){
            $data['user_id'] = auth()->user()->id;
        }
        
        // Validación
        $data['is_credit'] = (int)$data['is_credit'];
        $data['is_frequent'] = (int)$data['is_frequent'];
        $case = $this->purchase_cases["{$data['is_credit']}{$data['is_frequent']}"] ?? "none";
        $validation_result = $this->validaciones->purchase_registry_validation($data);

        if (!$validation_result['success']) {
            return back()->withErrors($validation_result['message'])->withInput();
        }
        // verifica si el usuario elimino el gasto como un gasto a credito 
        if($data['is_credit'] == 0 && $data['purchase_registry_credit_id'] && (!$data['credit_payment_frequency_id'] && !$data['qty_payment'] && !$data['remain_payment'])){
            // si se cumple la condicion se hace un softdelete en la tabla purchase_registry_credit
            $this->delete_row(prc::class,  $data['purchase_registry_credit_id'], 'soft');
            // Establece el valor de 'purchase_registry_credit_id' a null después de eliminarlo
            $data['purchase_registry_credit_id'] = null;
        }
        // verifica si el usuario elimino el gasto como un gasto a frecuente 
        if($data['is_frequent'] == 0 && $data['purchase_registry_frequent_id'] && (!$data['frequent_payment_frequency_id'] && !$data['next_insert_date'])){
            // si se cumple la condicion se hace un softdelete en la tabla purchase_registry_frequent
            $this->delete_row(prf::class,  $data['purchase_registry_frequent_id'], 'soft');
            // Establece el valor de 'purchase_registry_frequent_id' a null después de eliminarlo
            $data['purchase_registry_frequent_id'] = null;
        }

        switch ($case) {
            case 'is_credit':
                
                $data['payment_frequency_id'] = $data['credit_payment_frequency_id'];
                unset($data['credit_payment_frequency_id']);
        
                $error = $this->updateOrCreateRecord(
                    prc::class,
                    'purchase_registry_credit_id',
                    $data,
                    'Error al procesar el registro de compra a crédito.'
                );
                if ($error) return to_route('pr.index')->with('data', $error);
                break;
        
            case 'is_frequent':
                $data['payment_frequency_id'] = $data['frequent_payment_frequency_id'];
                unset($data['frequent_payment_frequency_id']);
        
                $error = $this->updateOrCreateRecord(
                    prf::class,
                    'purchase_registry_frequent_id',
                    $data,
                    'Error al procesar el registro de pago frecuente.'
                );
                if ($error) return to_route('pr.index')->with('data', $error);
                break;
        
            case 'both':
                $data['payment_frequency_id_credit'] = $data['credit_payment_frequency_id'];
                $data['payment_frequency_id_frequent'] = $data['frequent_payment_frequency_id'];
                unset($data['credit_payment_frequency_id'], $data['frequent_payment_frequency_id']);
        
                $errorCredit = $this->updateOrCreateRecord(
                    prc::class,
                    'purchase_registry_credit_id',
                    $data,
                    'Error al procesar el registro de pago a crédito.'
                );
        
                $errorFrequent = $this->updateOrCreateRecord(
                    prf::class,
                    'purchase_registry_frequent_id',
                    $data,
                    'Error al procesar el registro de pago frecuente.'
                );
        
                if ($errorCredit) return to_route('pr.index')->with('data', $errorCredit);
                if ($errorFrequent) return to_route('pr.index')->with('data', $errorFrequent);
                break;
        }

        $registry = PR::findOrFail($data['id']);
        $registry->update($data);

        
        // Guardar y manejar la respuesta
        $response = $registry->save() 
            ? ['success' => true, 'message' => '¡Registro actualizado correctamente!', 'severity' => 'success'] 
            : ['success' => false, 'message' => 'No se pudo actualizar el registro, por favor inténtelo más tarde', 'severity' => 'error'];

        return to_route('pr.index')->with('data', $response);

    }


}

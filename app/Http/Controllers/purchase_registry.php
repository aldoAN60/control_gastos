<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\purchase_registry as PR;
use App\Services\Validaciones;
class purchase_registry extends Controller
{
    protected $validaciones;
    public function __construct(Validaciones $validaciones){
        $this->validaciones = $validaciones;
    }
    public function index()
    {
        $registries = PR::PurchaseRegistry()->get();
        $pr = PR::format_registries($registries);

        $props = [
            'purchase_registries' => $pr, // Asegúrate que el nombre es 'purchase_registries'
        ];
        return inertia::render('purchase_registry/index', $props);
    }

    public function register_purchase(Request $request){
        $data = $request->all();
        
        if ($request->is('api/*')) {
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
}

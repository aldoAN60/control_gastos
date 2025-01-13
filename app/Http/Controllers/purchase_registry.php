<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class purchase_registry extends Controller
{
    public function index(){
        
        
        return inertia::render('purchase_registry/index');
    }

    public function registry_purchase(Request $request){
        $data = $request->all();
        $data['user'] = auth()->user()->id;
        if ($request->is('api/*')) {
            $source = 'API';
        } else {
            $source = 'WEB';
        }
        if(!empty($data)){

            return response()->json([
                'success' => true,
                'message' => 'Operación exitosa',
                'data' => $data,
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

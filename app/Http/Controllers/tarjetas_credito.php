<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Bancos;
use App\Services\Validaciones;
use App\Models\tarjeta_credito;
class tarjetas_credito extends Controller
{
    protected $metodo_pago =[
        'tarjeta_credito' => 1,
        'tarjeta_debito' => 2,
        'efectivo'=> 3 
    ];
    protected $validaciones;
    public function __construct(Validaciones $validaciones){
        $this->validaciones = $validaciones;
    }
    public function index(){
        $bancos = Bancos::all()->map(function($banco) {
            return $banco->only('id', 'nombre');
        });
        $tdc = tarjeta_credito::get_tdc();
        return Inertia::render('TDC/index', [
            'bancos' => $bancos,
            'tdc' => $tdc,
        ]);
    }
    public function registrar_TDC(Request $request){
        $respuesta = [];

        $resultado_val = $this->validaciones->tdc($request->all());
        
        if (!$resultado_val['exito']) {
            return back()->withErrors($resultado_val['mensajes'])->withInput();
        }

        // Obtener los datos validados
        $data = $resultado_val['data'];
        $tarjeta_credito = tarjeta_credito::create([
            'user_id' => auth()->user()->id,
            'metodo_id' =>  $this->metodo_pago['tarjeta_credito'],
            'banco_id' => $data['banco_id'],
            'alias' => $data['alias'],
            'limite_credito' => $data['limite_credito'],
            'fecha_corte' => $data['fecha_corte'],
            'fecha_pago' => $data['fecha_pago'],
        ]);
        if ($tarjeta_credito) {
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = '¡Tarjeta de crédito guardada correctamente!';
        } else {
            $respuesta['exito'] = false;
            $respuesta['mensaje'] = 'No se pudo guardar la tarjeta de crédito, por favor intentalo más tarde';
        }
        return back()->with('data',$respuesta);
    }
    
}

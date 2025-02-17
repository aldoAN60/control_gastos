<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\banks;
use App\Services\Validaciones;
use App\Models\tarjeta_credito;
class tarjetas_credito extends Controller
{
    protected $metodo_pago = [
        'tarjeta_credito' => 1,
        'tarjeta_debito' => 2,
        'efectivo' => 3
    ];
    protected $validaciones;
    public function __construct(Validaciones $validaciones)
    {
        $this->validaciones = $validaciones;
    }

    public function index()
    {
        $banks = banks::all()->map(function ($banco) {
            return $banco->only('id', 'name');
        });
        $tdc = tarjeta_credito::get_tarjetas();
        return Inertia::render('TDC/index', [
            'banks' => $banks,
            'tdc' => $tdc,
        ]);
    }
    public function registrar_TDC(Request $request)
    {
        $respuesta = [];
        $resultado_val = $this->validaciones->tdc($request->all());

        if (!$resultado_val['exito']) {
            return back()->withErrors($resultado_val['mensajes'])->withInput();
        }

        // Obtener los datos validados
        $data = $resultado_val['data'];

        $tarjeta_credito = tarjeta_credito::create([
            'user_id' => auth()->user()->id,
            'metodo_id' => $this->metodo_pago['tarjeta_credito'],
            'bank_id' => $data['bank_id'],
            'alias' => $data['alias'],
            'credit_limit' => $data['credit_limit'],
            'statement_date' => $data['statement_date'],
            'payment_date' => $data['payment_date'],
        ]);
        if ($tarjeta_credito) {
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = '¡Tarjeta de crédito guardada correctamente!';
            $respuesta['severity'] = 'success';
        } else {
            $respuesta['exito'] = false;
            $respuesta['mensaje'] = 'No se pudo guardar la tarjeta de crédito, por favor intentalo más tarde';
            $respuesta['severity'] = 'error';
        }

        return redirect()->route('tdc.index')->with('data', $respuesta);
    }
    public function actualizar_tdc(Request $request)
    {

        $respuesta = [];
        $resultado_val = $this->validaciones->tdc($request->all());
        if (!$resultado_val['exito']) {
            return back()->withErrors($resultado_val['mensajes'])->withInput();
        }
        // Obtener los datos validados
        $data = $resultado_val['data'];
        $tarjeta_credito = tarjeta_credito::find($request->id);

        if (!$tarjeta_credito) {
            $respuesta['mensaje'] = 'No existe la tarjeta de credito.';
            $respuesta['severity'] = 'error';
            return back()->withErrors($respuesta)->withInput();
        }

        $tarjeta_credito->bank_id = $data['bank_id'];
        $tarjeta_credito->alias = $data['alias'];
        $tarjeta_credito->credit_limit = $data['credit_limit'];
        $tarjeta_credito->statement_date = $data['statement_date'];
        $tarjeta_credito->payment_date = $data['payment_date'];

        if ($tarjeta_credito->save()) {
            $tarjeta_actualizada = tarjeta_credito::get_tarjeta($tarjeta_credito->id);
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = '¡Tarjeta de crédito Actualizada correctamente!';
            $respuesta['severity'] = 'success';
            $respuesta['data'] = $tarjeta_actualizada;
        } else {
            $respuesta['exito'] = false;
            $respuesta['mensaje'] = 'No se pudo actualizar la tarjeta de crédito, por favor intentalo más tarde';
            $respuesta['severity'] = 'error';
        }

        return redirect()->route('tdc.index')->with('data', $respuesta);



    }
    public function eliminar_tdc($id)
    {
        $respuesta = [];
        $tdc = tarjeta_credito::findOrFail($id);
        if ($tdc->delete()) {
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = '¡Tarjeta de crédito Eliminada correctamente!';
            $respuesta['severity'] = 'success';
        } else {
            $respuesta['exito'] = false;
            $respuesta['mensaje'] = 'No se pudo Eliminar la tarjeta de crédito, por favor intentalo más tarde';
            $respuesta['severity'] = 'error';
        }
        return redirect()->route('tdc.index')->with('data', $respuesta);
    }
}

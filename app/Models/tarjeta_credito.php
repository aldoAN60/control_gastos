<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tarjeta_credito extends Model
{
    protected $table = "TDC";
    protected $fillable = [
        'user_id',
        'metodo_id',
        'banco_id',
        'alias',
        'limite_credito',
        'fecha_corte',
        'fecha_pago',
    ];
    use HasFactory;
    public static function get_tdc(){
        $q_tdcs = tarjeta_credito::select('tdc.id', 'b.nombre', 'tdc.alias', 'tdc.limite_credito', 'tdc.fecha_corte', 'tdc.fecha_pago')
                ->join('bancos as b', 'b.id', '=', 'tdc.banco_id')
                ->where('user_id', auth()->id()) // Usar el ID del usuario autenticado
                ->get();

                return $q_tdcs;
    }
}

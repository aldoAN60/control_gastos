<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tarjeta_credito extends Model
{
    protected $table = "TDC";
    protected $fillable = [
        'user_id',
        'method_id',
        'bank_id',
        'alias',
        'credit_limit',
        'statement_date',
        'payment_date',
    ];
    use HasFactory;

    public function purchase_registry(){
        return $this->hasMany(purchase_registry::class, 'tdc_id');
    }
    public function banco(){
        return $this->belongsTo(banks::class, 'bank_id');
    }

    public static function get_tarjetas(){
        $q_tdcs = tarjeta_credito::select('tdc.id', 'b.id as bank_id', 'b.name', 'tdc.alias', 'tdc.credit_limit', 'tdc.statement_date','tdc.payment_date')
                ->join('banks as b', 'b.id', '=', 'tdc.bank_id')
                ->where('user_id', auth()->id()) // Usar el ID del usuario autenticado
                ->get();

                return $q_tdcs;
    }
    public static function get_tarjeta($id){
        $q_tdcs = tarjeta_credito::select('tdc.id', 'b.name', 'tdc.alias', 'tdc.credit_limit', 'tdc.statement_date','tdc.payment_date')
                ->join('banks as b', 'b.id', '=', 'tdc.bank_id')
                ->where('user_id', auth()->id()) // Usar el ID del usuario autenticado
                ->where('tdc.id',$id)
                ->first();

                return $q_tdcs;
    }
}

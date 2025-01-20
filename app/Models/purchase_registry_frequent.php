<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_registry_frequent extends Model
{
    protected $table = "registro_compras_frecuentes";

    public function payment_frequency(){
        return $this->belongsTo(payment_frequency::class, 'frecuencia_pago_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_registry extends Model
{
    protected $table = "registro_compras";

    protected $fillable = [
        'user_id',
        'tdc_id',
        'concepto',
        'monto',
        'categoria_id',
        'sub_categoria_id',
        'tipo_gasto',
        'metodo_pago_id',
        'registro_compras_frecuentes_id',
        'registro_compras_credito_id',
        'eliminado',
    ];
    use HasFactory;
}

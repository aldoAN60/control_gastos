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
}

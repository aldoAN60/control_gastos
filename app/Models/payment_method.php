<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_method extends Model
{
    use HasFactory;
    protected $table = 'metodo_pago';

    public function purchase_registry(){
        return $this->hasMany(purchase_registry::class, 'metodo_pago_id');
    }
}

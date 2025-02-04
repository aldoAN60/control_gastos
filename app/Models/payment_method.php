<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_method extends Model
{
    use HasFactory;
    protected $table = 'payment_method';

    public function purchase_registry(){
        return $this->hasMany(purchase_registry::class, 'payment_method_id');
    }
}

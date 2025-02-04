<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_registry_credit extends Model
{
    protected $table = "purchase_registry_credit";

    public function payment_frequency(){
        return $this->belongsTo(payment_frequency::class, 'payment_frequency_id');
    }
}

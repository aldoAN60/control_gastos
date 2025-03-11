<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_registry_credit extends Model
{
    protected $table = "purchase_registry_credit";
    protected $fillable = [
        'concept',
        'amount',
        'user_id',
        'tdc_id',
        'category_id',
        'sub_category_id',
        'payment_frequency_id',
        'qty_payment',
        'remain_payment',
        'paid',
        'delete',
        'spend_type',
    ];
    
    public function payment_frequency(){
        return $this->belongsTo(payment_frequency::class, 'payment_frequency_id');
    }
}

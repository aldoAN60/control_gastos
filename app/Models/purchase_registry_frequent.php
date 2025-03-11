<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_registry_frequent extends Model
{
    protected $table = "purchase_registry_frequent";
    protected $fillable = [
        'concept',
        'amount',
        'user_id',
        'spend_type',
        'category_id',
        'sub_category_id',
        'payment_frequency_id',
        'delete',
        'next_insert_date',
    ];
    

    public function payment_frequency(){
        return $this->belongsTo(payment_frequency::class, 'payment_frequency_id');
    }
}

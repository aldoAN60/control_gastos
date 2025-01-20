<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table = 'categorias';

    public function purchase_registry_category(){
        return $this->hasMany(purchase_registry::class, 'categoria_id');
    }
    public function puchase_registry_sub_category(){
        return $this->hasMany(purchase_registry::class, 'sub_categoria_id');
    }
}

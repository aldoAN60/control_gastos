<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    public function purchase_registry_category(){
        return $this->hasMany(purchase_registry::class, 'category_id');
    }
    public function puchase_registry_sub_category(){
        return $this->hasMany(purchase_registry::class, 'sub_category_id');
    }

    public static function get_categories()
    {
        $categories = self::select(
            'cat.id as category_id',
            'cat.name as category',
            'sub_cat.id as sub_category_id',
            'sub_cat.name as sub_category',
            'sub_cat.parent_id',
        )
        ->from('categories as cat')
        ->join('categories as sub_cat', 'sub_cat.parent_id', '=', 'cat.id')
        ->where('cat.active', 1)
        ->where('sub_cat.active', 1)
        ->get();
    
        return $categories->groupBy('category_id')->map(function ($items) {
            return [
                'category_id' => $items->first()->category_id,
                'category' => $items->first()->category,
                'sub_categories' => $items->map(function ($item) {
                    return [
                        'sub_category_id' => $item->sub_category_id,
                        'sub_category' => $item->sub_category,
                        'parent_id' => $item->parent_id,
                    ];
                })->values()
            ];
        })->values();
    }
    
}

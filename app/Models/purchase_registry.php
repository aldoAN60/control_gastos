<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tdc(){
        return $this->belongsTo(tarjeta_credito::class, 'tdc_id');
    }
    
    public function category(){
        return $this->belongsTo(category::class, 'categoria_id');
    }
    public function sub_category(){
        return $this->belongsTo(category::class, 'sub_categoria_id');
    }
    public function payment_method(){
        return $this->belongsTo(payment_method::class,'metodo_pago_id');
    }
    public function purchase_registry_credit(){
        return $this->belongsTo(purchase_registry_credit::class, 'registro_compras_credito_id');
    }
    public function purchase_registry_frequent(){
        return $this->belongsTo(purchase_registry_frequent::class, 'registro_compras_frecuentes_id');
    }

    /**
     * Obtener los registros de compra filtrados para un usuario autenticado.
     *
     * @param Builder $query
     * @param int|null $userId
     * @return Builder
     */
    public function scopePurchaseRegistry(Builder $query, $userId = null)
    {
        $userId = $userId ?? auth()->id();

        return $query->with([
            'user:id,nombre,apellido_paterno,apellido_materno,email',
            'tdc:id,alias,banco_id', // Solo trae id y alias de tdc
            'tdc.banco:id,nombre', 
            'category:id,nombre',
            'sub_category:id,nombre',
            'payment_method:id,metodo',
            'purchase_registry_credit:id,concepto,monto,frecuencia_pago_id,cantidad_pagos,pagos_restantes,created_at',
            'purchase_registry_credit.payment_frequency:id,frecuencia',
            'purchase_registry_frequent:id,concepto,monto,frecuencia_pago_id,registro_compras_insercion,created_at',
            'purchase_registry_frequent.payment_frequency:id,frecuencia',
        ])
        ->where('eliminado', 0)
        ->where('user_id', $userId)
        ->select([
            'id',
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
            'created_at',
            'updated_at',
        ]);
    }

    public static function format_registries($registries){
        return array_map(function ($registry) {
            return [
                'id' => $registry['id'],
                'user_id' => $registry['user_id'],
                'tdc' => self::format_tdc($registry['tdc']),
                'concept' => $registry['concepto'],
                'amount' => $registry['monto'],
                'category' => self::format_category($registry['category']),
                'sub_category' => self::format_category($registry['sub_category']),
                'payment_method' => self::format_payment_method($registry['payment_method']),
                'purchase_registry_credit' => self::format_purchase_registry_credit($registry['purchase_registry_credit'] ?? null),
                'purchase_registry_frequent' => self::format_purchase_registry_frequent($registry['purchase_registry_frequent'] ?? null),
                'created_at' => $registry['created_at'],
                'updated_at' => $registry['updated_at'],
            ];
        }, $registries->toArray());
    }

    private static function format_tdc($tdc)
    {
        if (empty($tdc)) {
            return null;
        }
        return [
            'id' => $tdc['id'],
            'alias' => $tdc['alias'],
            'bank_id' => $tdc['banco_id'],
            'bank_name' => $tdc['banco']['nombre'] ?? null,
        ];
    }

    private static function format_category($category)
    {
        return [
            'id' => $category['id'] ?? null,
            'name' => $category['nombre'] ?? null,
        ];
    }

    private static function format_payment_method($payment_method)
    {
        return [
            'id' => $payment_method['id'] ?? null,
            'method' => $payment_method['metodo'] ?? null,
        ];
    }

    private static function format_purchase_registry_credit($purchase_registry_credit)
    {
        if (empty($purchase_registry_credit)) {
            return null;
        }
        return [
            'id' => $purchase_registry_credit['id'],
            'payment_frequency' => [
                'id' => $purchase_registry_credit['payment_frequency']['id'] ?? null,
                'frequency' => $purchase_registry_credit['payment_frequency']['frecuencia'] ?? null,
            ],
            'qty_payment' => $purchase_registry_credit['cantidad_pagos'] ?? null,
            'qty_remain' => $purchase_registry_credit['pagos_restantes'] ?? null,
        ];
    }

    private static function format_purchase_registry_frequent($purchase_registry_frequent)
    {
        if (empty($purchase_registry_frequent)) {
            return null;
        }
        return [
            'id' => $purchase_registry_frequent['id'],
            'payment_frequency' => [
                'id' => $purchase_registry_frequent['payment_frequency']['id'] ?? null,
                'frequency' => $purchase_registry_frequent['payment_frequency']['frecuencia'] ?? null,
            ],
            'next_insert_date' => $purchase_registry_frequent['registro_compras_insercion'] ?? null,
        ];
    }

}

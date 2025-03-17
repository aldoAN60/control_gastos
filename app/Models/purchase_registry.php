<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class purchase_registry extends Model
{
    protected $table = "purchase_registry";

    protected $fillable = [
        'user_id',
        'tdc_id',
        'concept',
        'amount',
        'category_id',
        'sub_category_id',
        'spend_type',
        'payment_method_id',
        'purchase_registry_frequent_id',
        'purchase_registry_credit_id',
        'delete',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];
    

    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tdc(){
        return $this->belongsTo(tarjeta_credito::class, 'tdc_id');
    }
    
    public function category(){
        return $this->belongsTo(category::class, 'category_id');
    }
    public function sub_category(){
        return $this->belongsTo(category::class, 'sub_category_id');
    }
    public function payment_method(){
        return $this->belongsTo(payment_method::class,'payment_method_id');
    }
    public function purchase_registry_credit(){
        return $this->belongsTo(purchase_registry_credit::class, 'purchase_registry_credit_id');
    }
    public function purchase_registry_frequent(){
        return $this->belongsTo(purchase_registry_frequent::class, 'purchase_registry_frequent_id');
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
            'tdc:id,alias,bank_id',
            'tdc.banco:id,name', 
            'category:id,name',
            'sub_category:id,name',
            'payment_method:id,method',
            'purchase_registry_credit' => function ($query) {
                        $query->where('delete', 0)
                            ->select('id', 'concept', 'amount', 'payment_frequency_id', 'qty_payment', 'spend_type', 'remain_payment', 'created_at');
                    },
            'purchase_registry_credit.payment_frequency:id,frequency',
            'purchase_registry_frequent' => function ($query) {
                $query->where('delete', 0)
                ->select('id','concept','amount','spend_type','payment_frequency_id','next_insert_date','created_at');
            },
            'purchase_registry_frequent.payment_frequency:id,frequency',
        ])
        ->where('delete', 0)
        ->where('user_id', $userId)
        ->select([
            'id',
            'user_id',
            'tdc_id',
            'concept',
            'amount',
            'category_id',
            'sub_category_id',
            'spend_type',
            'payment_method_id',
            'purchase_registry_frequent_id',
            'purchase_registry_credit_id',
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
                'concept' => $registry['concept'],
                'amount' => $registry['amount'],
                'category' => self::format_category($registry['category']),
                'sub_category' => self::format_category($registry['sub_category']),
                'payment_method' => self::format_payment_method($registry['payment_method']),
                'spend_type' => $registry['spend_type'],
                'purchase_registry_credit' => self::format_purchase_registry_credit($registry['purchase_registry_credit'] ?? null),
                'purchase_registry_frequent' => self::format_purchase_registry_frequent($registry['purchase_registry_frequent'] ?? null),
                'created_at' => $registry['created_at'],
                'updated_at' => $registry['updated_at'],
            ];
        }, $registries->toArray());
    }

    public static function format_registries_put($registries){
            return [
                'id' => $registries['id'],
                'user_id' => $registries['user_id'],
                'tdc_id' => $registries['tdc']['id'] ?? null,
                'concept' => $registries['concept'],
                'amount' => $registries['amount'],
                'category_id' => $registries['category']['id'],
                'sub_category_id' => $registries['sub_category']['id'],
                'payment_method_id' => $registries['payment_method']['id'],
                'spend_type' => $registries['spend_type'],
                'purchase_registry_credit_id' => $registries['purchase_registry_credit']['id'] ?? null,
                'purchase_registry_frequent_id' => $registries['purchase_registry_frequent']['id'] ?? null,
            ];
        
    }

    private static function format_tdc($tdc)
    {
        if (empty($tdc)) {
            return null;
        }
        return [
            'id' => $tdc['id'],
            'alias' => $tdc['alias'],
            'bank_id' => $tdc['bank_id'],
            'bank_name' => $tdc['banco']['nombre'] ?? null,
        ];
    }

    private static function format_category($category)
    {
        return [
            'id' => $category['id'] ?? null,
            'name' => $category['name'] ?? null,
        ];
    }

    private static function format_payment_method($payment_method)
    {
        return [
            'id' => $payment_method['id'] ?? null,
            'method' => $payment_method['method'] ?? null,
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
                'frequency' => $purchase_registry_credit['payment_frequency']['frequency'] ?? null,
            ],
            'qty_payment' => $purchase_registry_credit['qty_payment'] ?? null,
            'remain_payment' => $purchase_registry_credit['remain_payment'] ?? null,
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
                'frequency' => $purchase_registry_frequent['payment_frequency']['frequency'] ?? null,
            ],
            'next_insert_date' => $purchase_registry_frequent['next_insert_date'] ?? null,
        ];
    }

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_compras', function (Blueprint $table) {
            $table->id(); // ID de la compra
            $table->foreignId('user_id')->constrained('users'); // Relación con la tabla users
            $table->foreignId('tdc_id')->nullable()->constrained('tdc'); // Relación con la tabla tdc
            $table->string('concept', 24); // Concepto de la compra
            $table->decimal('amount', 10, 2); // Monto de la compra
            $table->foreignId('category_id')->constrained('categorias'); // Relación con la tabla categorias
            $table->foreignId('sub_category_id')->constrained('categorias'); // Relación con la tabla categorias (subcategoría)
            $table->enum('spend_type', ['necesario', 'secundario', 'precindible']); // Tipo de gasto
            $table->foreignId('payment_method_id')->nullable()->constrained('metodo_pago'); // Relación con la tabla metodo_pago
            $table->foreignId('purchase_registry_frequent_id')->nullable()->constrained('registro_compras_frecuentes');
            $table->foreignId('purchase_registry_credit_id')->nullable()->constrained('registro_compras_credito');
            $table->boolean('delete')->default(false); // Baja lógica
            $table->timestamps(); // Timestamps para creación y actualización
        
            // Índices
            $table->index('user_id');
            $table->index('tdc_id');
            $table->index('category_id');
            $table->index('sub_category_id');
            $table->index('spend_type');
            $table->index('payment_method_id');
            $table->index('purchase_registry_frequent_id');
            $table->index('purchase_registry_credit_id');
        });
        
    }

    /**
     * Revocar las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_compras');
    }
};
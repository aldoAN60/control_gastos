<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_compras_credito', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('concepto', 24); // Concepto de la compra
            $table->decimal('monto', 10, 2); // Monto del crédito
            $table->foreignId('user_id')->constrained('users'); // Relación con la tabla users
            $table->foreignId('tdc_id')->nullable()->constrained('tdc'); // Relación con la tabla tdc
            $table->foreignId('categoria_id')->constrained('categorias'); // Relación con la tabla categorias
            $table->foreignId('sub_categoria_id')->constrained('categorias'); // Relación con la tabla categorias (subcategorías)
            $table->foreignId('frecuencia_pago_id')->constrained('frecuencias_pago'); // Relación con la tabla frecuencias_pago
            $table->integer('cantidad_pagos'); // Cantidad total de pagos
            $table->integer('pagos_restantes'); // Pagos restantes
            $table->boolean('pagado')->default(false); // Indica si el crédito está liquidado
            $table->boolean('eliminado')->default(false); // Baja lógica
            $table->timestamps(); // Fechas de creación y actualización

            // Índices adicionales
            $table->index('user_id');
            $table->index('tdc_id');
            $table->index('frecuencia_pago_id');
            $table->index('pagado');
            $table->index('eliminado');
            $table->index('categoria_id');
            $table->index('sub_categoria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_compras_credito');
    }
};

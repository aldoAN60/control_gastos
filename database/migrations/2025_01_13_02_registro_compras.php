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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla users
            $table->string('concepto', 24); // Concepto de la compra
            $table->decimal('monto', 10, 2); // Monto de la compra
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade'); // Relación con la tabla categorias
            $table->foreignId('sub_categoria_id')->constrained('categorias')->onDelete('cascade'); // Relación con la tabla categorias (subcategoría)
            $table->enum('tipo_gasto', ['necesario', 'secundario', 'precindible']); // Tipo de gasto
            $table->foreignId('metodo_pago_id')->constrained('metodo_pago')->onDelete('cascade'); // Relación con la tabla metodo_pago
            $table->tinyInteger('credito'); // Indicador de si es un gasto a crédito (0 o 1)
            $table->enum('frecuencia_pago', ['unico', 'diario', 'semanal', 'quincenal', 'mensual', 'bimestral', 'trimestral', 'semestral', 'anual'])->nullable(); // Frecuencia de pago
            $table->date('fecha_pago_inicial')->nullable(); // Fecha de pago inicial
            $table->date('fecha_pago_final')->nullable(); // Fecha de pago final
            $table->timestamps(); // Timestamps para creación y actualización
            // Índices
            $table->index('user_id');
            $table->index('categoria_id');
            $table->index('sub_categoria_id');
            $table->index('tipo_gasto');
            $table->index('metodo_pago_id');
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
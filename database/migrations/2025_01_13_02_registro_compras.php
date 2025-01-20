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
            $table->string('concepto', 24); // Concepto de la compra
            $table->decimal('monto', 10, 2); // Monto de la compra
            $table->foreignId('categoria_id')->constrained('categorias'); // Relación con la tabla categorias
            $table->foreignId('sub_categoria_id')->constrained('categorias'); // Relación con la tabla categorias (subcategoría)
            $table->enum('tipo_gasto', ['necesario', 'secundario', 'precindible']); // Tipo de gasto
            $table->foreignId('metodo_pago_id')->nullable()->constrained('metodo_pago'); // Relación con la tabla metodo_pago
            $table->foreignId('registro_compras_frecuentes_id')->nullable()->constrained('registro_compras_frecuentes');
            $table->foreignId('registro_compras_credito_id')->nullable()->constrained('registro_compras_credito');
            $table->boolean('eliminado')->default(false); // Baja lógica
            $table->timestamps(); // Timestamps para creación y actualización
        
            // Índices
            $table->index('user_id');
            $table->index('tdc_id');
            $table->index('categoria_id');
            $table->index('sub_categoria_id');
            $table->index('tipo_gasto');
            $table->index('metodo_pago_id');
            $table->index('registro_compras_frecuentes_id');
            $table->index('registro_compras_credito_id');
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
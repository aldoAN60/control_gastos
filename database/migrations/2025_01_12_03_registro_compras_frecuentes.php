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
        Schema::create('registro_compras_frecuentes', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('concepto', 24); // Concepto de la compra frecuente
            $table->decimal('monto', 10, 2); // Monto de la compra
            $table->foreignId('user_id')->constrained('users'); // Relación con la tabla users
            $table->enum('tipo_gasto', ['necesario', 'secundario', 'precindible']); // Tipo de gasto
            $table->foreignId('categoria_id')->constrained('categorias'); // Relación con la tabla categorias
            $table->foreignId('sub_categoria_id')->constrained('categorias'); // Relación con la tabla categorias (subcategorías)
            $table->foreignId('frecuencia_pago_id')->constrained('frecuencias_pago'); // Relación con frecuencias de pago
            $table->boolean('eliminado')->default(false); // Baja lógica
            $table->date('registro_compras_insercion')->nullable(); // Fecha de la próxima inserción
            $table->timestamps(); // Fechas de creación y actualización

            // Índices adicionales
            $table->index('user_id');
            $table->index('categoria_id');
            $table->index('sub_categoria_id');
            $table->index('tipo_gasto');
            $table->index('frecuencia_pago_id');
            $table->index('eliminado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_compras_frecuentes');
    }
};

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
        Schema::create('purchase_registry_frequent', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('concept', 24); // Concepto de la compra frecuente
            $table->decimal('amount', 10, 2); // Monto de la compra
            $table->foreignId('user_id')->constrained('users'); // Relación con la tabla users
            $table->enum('spend_type', ['necesario', 'secundario', 'precindible']); // Tipo de gasto
            $table->foreignId('category_id')->constrained('categories'); // Relación con la tabla categorias
            $table->foreignId('sub_category_id')->constrained('categories'); // Relación con la tabla categorias (subcategorías)
            $table->foreignId('payment_frequency_id')->constrained('payment_frequency'); // Relación con frecuencias de pago
            $table->boolean('delete')->default(false); // Baja lógica
            $table->date('next_insert_date')->nullable(); // Fecha de la próxima inserción
            $table->timestamps(); // Fechas de creación y actualización

            // Índices adicionales
            $table->index('user_id');
            $table->index('category_id');
            $table->index('sub_category_id');
            $table->index('spend_type');
            $table->index('payment_frequency_id');
            $table->index('delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_registry_frequent');
    }
};

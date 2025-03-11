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
        Schema::create('purchase_registry_credit', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('concept', 24); // Concepto de la compra
            $table->decimal('amount', 10, 2); // Monto del crédito
            $table->foreignId('user_id')->constrained('users'); // Relación con la tabla users
            $table->enum('spend_type', ['necesario', 'secundario', 'precindible']); // Tipo de gasto
            $table->foreignId('tdc_id')->nullable()->constrained('tdc'); // Relación con la tabla tdc
            $table->foreignId('category_id')->constrained('categories'); // Relación con la tabla categorias
            $table->foreignId('sub_category_id')->constrained('categories'); // Relación con la tabla categorias (subcategorías)
            $table->foreignId('payment_frequency_id')->constrained('payment_frequency'); // Relación con la tabla frecuencias_pago
            $table->integer('qty_payment'); // Cantidad total de pagos
            $table->integer('remain_payment'); // Pagos restantes
            $table->boolean('paid')->default(false); // Indica si el crédito está liquidado
            $table->boolean('delete')->default(false); // Baja lógica
            $table->timestamps(); // Fechas de creación y actualización

            // Índices adicionales
            $table->index('user_id');
            $table->index('tdc_id');
            $table->index('payment_frequency_id');
            $table->index('paid');
            $table->index('datele');
            $table->index('category_id');
            $table->index('sub_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_registry_credit');
    }
};

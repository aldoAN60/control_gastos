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
        Schema::create('frecuencias_pago', function (Blueprint $table) {
            $table->id(); // ID único
            $table->string('frecuencia', 15)->index(); // Frecuencia (semanal, quincenal, etc.)
            $table->integer('dias'); // Días correspondientes a la frecuencia
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frecuencias_pago');
    }
};

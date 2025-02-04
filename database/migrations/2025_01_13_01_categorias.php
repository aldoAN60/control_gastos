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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // ID de la categoría
            $table->string('name', 34); // Nombre de la categoría
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // Relación con la misma tabla (subcategorías)
            $table->tinyInteger('active')->default(1); // Indicador de si la categoría está activa (1 = activa, 0 = inactiva)
            $table->timestamps(); // Timestamps para creación y actualización
        
            // Índices
            $table->index('parent_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

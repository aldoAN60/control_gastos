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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id();
            $table->integer('clave')->nullable(false); // Ejemplo de un campo de tipo string
            $table->string('nombre')->nullable(false); // Ejemplo de un campo de tipo string
            $table->string('razon_social')->nullable(false); // Ejemplo de un campo de tipo string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos');
    }
};

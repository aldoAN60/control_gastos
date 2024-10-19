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
        Schema::create('TDC', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false);
            $table->integer('metodo_id')->nullable(false);
            $table->integer('banco_id')->nullable(false);
            $table->string('alias')->nullable();
            $table->integer('limite_credito')->nullable();
            $table->integer('fecha_corte')->nullable(false);
            $table->integer('fecha_pago')->nullable(false);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TDC');
    }
};

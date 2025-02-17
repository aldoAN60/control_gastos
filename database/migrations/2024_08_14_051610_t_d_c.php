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
            $table->integer('method_id')->nullable(false);
            $table->integer('bank_id')->nullable(false);
            $table->string('alias')->nullable();
            $table->integer('credit_limit')->nullable();
            $table->integer('statement_date')->nullable(false);
            $table->integer('payment_date')->nullable(false);
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

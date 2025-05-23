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
        Schema::create('pagos', function (Blueprint $table) {
            $table->integer('id_pago', true);
            $table->integer('id_cliente')->index('id_cliente');
            $table->date('fecha_plazo')->nullable();
            $table->decimal('monto_debe', 10)->nullable();
            $table->decimal('monto_pagado', 10)->nullable();
            $table->string('descripcion_pago', 100)->nullable();
            $table->date('fecha_cancelada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

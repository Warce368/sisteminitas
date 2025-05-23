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
        Schema::create('servicios', function (Blueprint $table) {
            $table->integer('id_servicio', true);
            $table->string('nombre_servicio', 50)->nullable();
            $table->string('descripcion', 50)->nullable();
            $table->integer('valor_servicio')->nullable();
            $table->integer('velocidad_subida')->nullable();
            $table->integer('velocidad_bajada')->nullable();
            $table->timestamp('fecha')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};

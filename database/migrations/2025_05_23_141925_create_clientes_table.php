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
        Schema::create('clientes', function (Blueprint $table) {
            $table->integer('id_cliente', true);
            $table->integer('id_servicio')->index('id_servicio');
            $table->integer('id_direccion')->index('id_direccion');
            $table->string('nombre', 50)->nullable();
            $table->enum('tipo_persona', ['NATURAL', 'JURIDICA'])->nullable();
            $table->enum('tipo_documento', ['DNI', 'RUC'])->nullable();
            $table->string('documento', 50)->nullable();
            $table->string('sexo', 50)->nullable();
            $table->string('telefono1', 50)->nullable();
            $table->string('telefono2', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->string('ip', 50)->nullable();
            $table->string('ip_fija', 50)->nullable();
            $table->string('coordenadas', 50)->nullable();
            $table->string('modo_pago', 50)->nullable();
            $table->string('prestado', 50)->nullable();
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

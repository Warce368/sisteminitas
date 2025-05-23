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
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreign(['id_servicio'], 'clientes_ibfk_1')->references(['id_servicio'])->on('servicios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_direccion'], 'clientes_ibfk_2')->references(['id_direccion'])->on('direcciones')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('clientes_ibfk_1');
            $table->dropForeign('clientes_ibfk_2');
        });
    }
};

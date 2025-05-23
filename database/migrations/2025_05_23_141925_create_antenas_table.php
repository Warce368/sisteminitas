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
        Schema::create('antenas', function (Blueprint $table) {
            $table->integer('id_antena', true);
            $table->integer('id_direccion')->index('id_direccion');
            $table->string('nombre_antena', 50)->nullable();
            $table->string('ip', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antenas');
    }
};

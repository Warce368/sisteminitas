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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->integer('id_direccion', true);
            $table->integer('id_zona')->index('id_zona');
            $table->string('nombre_direccion', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};

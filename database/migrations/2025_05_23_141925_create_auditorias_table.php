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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accion');
            $table->string('tabla');
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('auditorias_user_id_foreign');
            $table->timestamps();
            $table->text('descripcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};

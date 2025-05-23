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
        Schema::table('antenas', function (Blueprint $table) {
            $table->foreign(['id_direccion'], 'antenas_ibfk_1')->references(['id_direccion'])->on('direcciones')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antenas', function (Blueprint $table) {
            $table->dropForeign('antenas_ibfk_1');
        });
    }
};

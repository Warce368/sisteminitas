<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegistroIdToAuditoriasTable extends Migration
{
    public function up()
    {
        Schema::table('auditorias', function (Blueprint $table) {
            $table->unsignedBigInteger('registro_id')->nullable()->after('tabla');
        });
    }

    public function down()
    {
        Schema::table('auditorias', function (Blueprint $table) {
            $table->dropColumn('registro_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->enum('role', ['ADMINISTRADOR', 'OPERADOR'])->default('OPERADOR');
        });

        // Insertar usuario por defecto
        // Crear usuario administrador inicial
    

        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'minitas@gmail.com',
            'password' => Hash::make('marcello'),
            'role' => 'ADMINISTRADOR',
            'email_verified_at' => now(), // Marcar como verificado
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

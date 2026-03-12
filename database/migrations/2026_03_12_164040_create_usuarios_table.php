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
       Schema::create('usuario', function (Blueprint $table) {
            $table->id('idusuario');
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno');
            $table->string('correo')->unique();
            $table->string('contrasena');
            $table->string('rol');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

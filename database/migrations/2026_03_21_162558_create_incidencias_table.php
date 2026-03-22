<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id('idincidencia');
            $table->unsignedBigInteger('user_id'); // Técnico que registra
            $table->unsignedBigInteger('idusuario')->nullable(); // Usuario involucrado
            $table->unsignedBigInteger('idlab'); // Laboratorio
            $table->string('idequipo')->nullable(); // Equipo opcional
            $table->dateTime('fechahora');
            $table->text('descripcion');
            $table->text('solucion')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('firmadigital'); // Firma digital como imagen o base64
            $table->enum('estado', ['pendiente','en proceso','resuelto','inactivo'])->default('pendiente'); 
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->foreign('idlab')->references('idlab')->on('laboratorio');
        });
    }

    public function down()
    {
        Schema::dropIfExists('incidencias');
    }
};

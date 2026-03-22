<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id('idmantenimiento');

            // 🔗 Relaciones
            $table->unsignedBigInteger('idusuario');
            $table->unsignedBigInteger('idlab');

            // 📅 Fecha automática
            $table->dateTime('fechaHora');

            // 📊 Datos del mantenimiento
            $table->integer('totalequipos')->nullable();
            $table->integer('equiposoperativos')->nullable();
            $table->integer('equiposreparacion')->nullable();

            $table->integer('preventivos')->nullable();
            $table->integer('correctivos')->nullable();
            $table->integer('reprogramados')->nullable();

            // 🔗 Claves foráneas
            $table->foreign('idusuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idlab')->references('idlab')->on('laboratorio')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};

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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id(); // ID del equipo
            $table->string('nombre'); // Nombre o identificador del equipo

            // FK manual hacia 'laboratorio.idlab'
            $table->unsignedBigInteger('laboratorio_id');
            $table->foreign('laboratorio_id')->references('idlab')->on('laboratorio')->onDelete('cascade');

            $table->string('descripcion')->nullable(); // Descripción opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};

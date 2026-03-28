<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('idasistencia');

            $table->unsignedBigInteger('idusuario');
            $table->unsignedBigInteger('idlaboratorio');

            $table->dateTime('entrada');
            $table->dateTime('salida')->nullable();
            $table->date('fecha');

            $table->timestamps();

            // Foreign keys
            $table->foreign('idusuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idlaboratorio')->references('idlab')->on('laboratorio')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};

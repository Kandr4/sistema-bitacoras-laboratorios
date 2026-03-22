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
        Schema::create('fallas', function (Blueprint $table) {
            $table->id();

            // FK hacia users
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            // FK hacia laboratorio.idlab
            $table->unsignedBigInteger('laboratorio_id');
            $table->foreign('laboratorio_id')->references('idlab')->on('laboratorio')->onDelete('cascade');

            // FK hacia equipos.id
            $table->unsignedBigInteger('equipo_id');
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');

            $table->enum('tipo_falla', ['hardware','software','red','perifericos','otros']);
            $table->text('descripcion');
            $table->enum('estado', ['pendiente','en revision','resuelto'])->default('pendiente');

            $table->timestamps(); // created_at = fecha y hora del reporte
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fallas');
    }
};

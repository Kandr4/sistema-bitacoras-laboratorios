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
    Schema::create('solicitudes', function (Blueprint $table) {
        $table->id();

        // usuario (este sí está normal)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // 🔴 CORRECCIÓN AQUÍ (laboratorio)
        $table->unsignedBigInteger('laboratorio_id');

        $table->integer('cantidad');
        $table->string('descripcion');
        $table->text('caracteristicas');
        $table->decimal('costo_unitario', 10, 2);
        $table->text('justificacion');

        $table->string('imagen')->nullable();

        $table->enum('estado', ['pendiente', 'autorizada', 'rechazada', 'en_proceso'])
              ->default('pendiente');

        $table->text('comentario_admin')->nullable();

        // admin
        $table->foreignId('validado_por')->nullable()->constrained('users')->nullOnDelete();

        // fecha automática
        $table->timestamp('fecha_solicitud')->useCurrent();

        $table->timestamps();

        // 🔴 FOREIGN KEYS (IMPORTANTE)
        $table->foreign('laboratorio_id')
              ->references('idlab')   // 👈 tu PK real
              ->on('laboratorio')     // 👈 tu tabla real
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->string('asignatura')->nullable()->after('fecha');
            $table->unsignedTinyInteger('cuatrimestre')->nullable()->after('asignatura');
            $table->char('grupo', 1)->nullable()->after('cuatrimestre');
            $table->string('carrera')->nullable()->after('grupo');
            $table->string('nombre_practica')->nullable()->after('carrera');
        });
    }

    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropColumn(['asignatura', 'cuatrimestre', 'grupo', 'carrera', 'nombre_practica']);
        });
    }
};

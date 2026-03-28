<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laboratorio', function (Blueprint $table) {
            $table->string('qr_token')->nullable()->unique()->after('estado');
        });
    }

    public function down(): void
    {
        Schema::table('laboratorio', function (Blueprint $table) {
            $table->dropColumn('qr_token');
        });
    }
};

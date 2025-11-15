<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            // Eliminar FK si existe
            try {
                $table->dropForeign(['estudiante_id']);
            } catch (\Throwable $e) {}

            // Eliminar columna
            try {
                $table->dropColumn('estudiante_id');
            } catch (\Throwable $e) {}

            // Volver a crear columna como NULLABLE
            $table->unsignedBigInteger('estudiante_id')->nullable()->after('mentor_id');

            // Restaurar FK opcional
            $table->foreign('estudiante_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            try {
                $table->dropForeign(['estudiante_id']);
            } catch (\Throwable $e) {}

            $table->dropColumn('estudiante_id');

            $table->unsignedBigInteger('estudiante_id')->after('mentor_id')->nullable(false);
            $table->foreign('estudiante_id')->references('id')->on('users');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (!Schema::hasColumn('mentorias', 'fecha_programada')) {
                $table->date('fecha_programada')->nullable()->after('fecha_mentoria');
            }

            if (!Schema::hasColumn('mentorias', 'hora_programada')) {
                $table->time('hora_programada')->nullable()->after('fecha_programada');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (Schema::hasColumn('mentorias', 'hora_programada')) {
                $table->dropColumn('hora_programada');
            }

            if (Schema::hasColumn('mentorias', 'fecha_programada')) {
                $table->dropColumn('fecha_programada');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (! Schema::hasColumn('mentorias', 'jitsi_room')) {
                $table->string('jitsi_room')->nullable()->after('modalidad');
            }

            if (! Schema::hasColumn('mentorias', 'link_sesion')) {
                $table->string('link_sesion')->nullable()->after('jitsi_room');
            }

            foreach (['enlace_reunion', 'enlace_sesion'] as $column) {
                if (Schema::hasColumn('mentorias', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (! Schema::hasColumn('mentorias', 'enlace_reunion')) {
                $table->string('enlace_reunion')->nullable()->after('modalidad');
            }

            if (! Schema::hasColumn('mentorias', 'enlace_sesion')) {
                $afterColumn = Schema::hasColumn('mentorias', 'enlace_reunion')
                    ? 'enlace_reunion'
                    : 'modalidad';

                $table->string('enlace_sesion')->nullable()->after($afterColumn);
            }

            if (Schema::hasColumn('mentorias', 'link_sesion')) {
                $table->dropColumn('link_sesion');
            }
        });
    }
};

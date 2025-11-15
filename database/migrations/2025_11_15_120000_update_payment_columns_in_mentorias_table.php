<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (! Schema::hasColumn('mentorias', 'link_pago')) {
                $table->string('link_pago')->nullable()->after('monto');
            }

            if (! Schema::hasColumn('mentorias', 'jitsi_room')) {
                $table->string('jitsi_room')->nullable()->after('link_pago');
            }
        });

        if (Schema::hasColumn('mentorias', 'estado')) {
            DB::table('mentorias')
                ->where('estado', 'confirmada')
                ->update(['estado' => 'aceptada']);

            DB::statement("ALTER TABLE mentorias MODIFY estado ENUM('borrador','publicada','pendiente','aceptada','pagada','completada','cancelada') DEFAULT 'pendiente'");
        }
    }

    public function down(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (Schema::hasColumn('mentorias', 'link_pago')) {
                $table->dropColumn('link_pago');
            }
            // No eliminamos jitsi_room en el rollback para evitar quitar columnas existentes previamente.
        });

        if (Schema::hasColumn('mentorias', 'estado')) {
            DB::table('mentorias')
                ->where('estado', 'aceptada')
                ->update(['estado' => 'confirmada']);

            DB::statement("ALTER TABLE mentorias MODIFY estado ENUM('pendiente','confirmada','completada','cancelada') DEFAULT 'pendiente'");
        }
    }
};

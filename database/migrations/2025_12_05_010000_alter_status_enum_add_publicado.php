<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        DB::statement("ALTER TABLE cursos MODIFY status ENUM('borrador','pendiente','aprobado','rechazado','publicado') NOT NULL DEFAULT 'borrador'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        DB::statement("ALTER TABLE cursos MODIFY status ENUM('borrador','pendiente','aprobado','rechazado') NOT NULL DEFAULT 'borrador'");
    }
};

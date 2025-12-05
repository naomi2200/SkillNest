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

        DB::statement("ALTER TABLE cursos MODIFY status ENUM('borrador','pendiente','aprobado','rechazado','publicado') DEFAULT 'borrador'");
        DB::statement("ALTER TABLE cursos MODIFY review_status ENUM('draft','pending','approved','rejected') DEFAULT 'draft'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        DB::statement("ALTER TABLE cursos MODIFY status ENUM('borrador','pendiente','aprobado','rechazado') DEFAULT 'borrador'");
        DB::statement("ALTER TABLE cursos MODIFY review_status ENUM('draft','pending','approved','rejected') DEFAULT 'draft'");
    }
};

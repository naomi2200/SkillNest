<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE cursos
            MODIFY status ENUM('borrador','pendiente','aprobado','rechazado')
            DEFAULT 'borrador'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE cursos
            MODIFY status ENUM('borrador','activo','inactivo')
            DEFAULT 'borrador'
        ");
    }
};

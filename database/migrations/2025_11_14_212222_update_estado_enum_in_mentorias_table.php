<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE mentorias 
            MODIFY estado ENUM(
                'publicada',
                'pendiente',
                'confirmada',
                'pagada',
                'completada',
                'cancelada'
            ) 
            NOT NULL DEFAULT 'publicada'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE mentorias 
            MODIFY estado ENUM(
                'pendiente',
                'confirmada',
                'completada',
                'cancelada'
            ) 
            NOT NULL DEFAULT 'pendiente'
        ");
    }
};

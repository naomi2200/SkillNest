<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE mentorias MODIFY payment_status VARCHAR(50) NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE mentorias MODIFY payment_status VARCHAR(50) NOT NULL DEFAULT 'pending'");
    }
};

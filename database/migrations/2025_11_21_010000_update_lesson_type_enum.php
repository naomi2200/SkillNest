<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE lessons MODIFY type ENUM('video','reading','live','quiz','file') DEFAULT 'video'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE lessons MODIFY type ENUM('video','reading','live','quiz') DEFAULT 'video'");
    }
};

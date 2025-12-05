<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        Schema::table('cursos', function (Blueprint $table) {
            if (! Schema::hasColumn('cursos', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('review_status');
            }
            if (! Schema::hasColumn('cursos', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        Schema::table('cursos', function (Blueprint $table) {
            if (Schema::hasColumn('cursos', 'reviewed_by')) {
                $table->dropColumn('reviewed_by');
            }
            if (Schema::hasColumn('cursos', 'reviewed_at')) {
                $table->dropColumn('reviewed_at');
            }
        });
    }
};

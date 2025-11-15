<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('mentor_profiles', 'especialidad')) {
                $table->string('especialidad')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mentor_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('mentor_profiles', 'especialidad')) {
                $table->dropColumn('especialidad');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'avatar_url')) {
                $table->string('avatar_url')->nullable()->after('password');
            }
            if (! Schema::hasColumn('users', 'timezone')) {
                $table->string('timezone')->nullable()->after('avatar_url');
            }
            if (! Schema::hasColumn('users', 'notification_channel')) {
                $table->string('notification_channel')->default('email')->after('timezone');
            }
            if (! Schema::hasColumn('users', 'profile_level')) {
                $table->string('profile_level')->default('principiante')->after('notification_channel');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar_url', 'timezone', 'notification_channel', 'profile_level']);
        });
    }
};

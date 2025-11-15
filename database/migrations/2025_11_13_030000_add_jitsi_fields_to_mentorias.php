<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (!Schema::hasColumn('mentorias', 'jitsi_room')) {
                $table->string('jitsi_room')->nullable()->after('modalidad');
            }

            if (!Schema::hasColumn('mentorias', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'refunded'])
                    ->default('pending')
                    ->after('jitsi_room');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (Schema::hasColumn('mentorias', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('mentorias', 'jitsi_room')) {
                $table->dropColumn('jitsi_room');
            }
        });
    }
};

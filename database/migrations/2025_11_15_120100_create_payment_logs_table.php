<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentoria_id')->constrained('mentorias')->cascadeOnDelete();
            $table->foreignId('estudiante_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('monto_total', 8, 2);
            $table->decimal('monto_mentor', 8, 2)->default(0);
            $table->decimal('monto_plataforma', 8, 2)->default(0);
            $table->string('metodo')->nullable();
            $table->string('referencia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};

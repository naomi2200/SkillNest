<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();

            // perfil
            $table->string('foto')->nullable();
            $table->string('profesion')->nullable();
            $table->integer('experiencia_anios')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('categorias')->nullable();
            $table->string('skills')->nullable();
            $table->decimal('precio_hora', 8, 2)->default(0);
            $table->string('nivel_experiencia')->nullable();

            // relación con users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_profiles');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar tablas duplicadas si existen
        if (Schema::hasTable('courses')) {
            Schema::dropIfExists('courses');
        }
        
        if (Schema::hasTable('cursos')) {
            Schema::dropIfExists('cursos');
        }

        // Crear la tabla CORRECTA
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('duration');
            $table->enum('level', ['principiante', 'intermedio', 'avanzado']);
            $table->string('category');
            $table->string('image_url')->nullable();
            $table->enum('status', ['borrador', 'pendiente', 'aprobado', 'rechazado'])->default('borrador');
            $table->enum('review_status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('objectives')->nullable();
            $table->text('requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};

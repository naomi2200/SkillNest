<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            if (!Schema::hasColumn('cursos', 'review_status')) {
                $table->enum('review_status', ['draft', 'pending', 'approved', 'rejected'])
                    ->default('draft')
                    ->after('status');
            }

            if (!Schema::hasColumn('cursos', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('review_status');
            }

            if (!Schema::hasColumn('cursos', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('published_at');
            }
        });

        Schema::create('course_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('cursos')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->boolean('requires_quiz')->default(true);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', ['video', 'reading', 'live', 'quiz'])->default('video');
            $table->integer('duration_minutes')->nullable();
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->string('resource_url')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedTinyInteger('pass_score')->default(70);
            $table->boolean('is_final')->default(true);
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question');
            $table->json('options');
            $table->string('correct_option');
            $table->text('explanation')->nullable();
            $table->timestamps();
        });

        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('cursos')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('course_modules')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->cascadeOnDelete();
            $table->enum('status', ['locked', 'in_progress', 'completed'])->default('locked');
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('cursos')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->string('reference')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->unique(['course_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('student_progress');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('course_modules');

        Schema::table('cursos', function (Blueprint $table) {
            if (Schema::hasColumn('cursos', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
            if (Schema::hasColumn('cursos', 'published_at')) {
                $table->dropColumn('published_at');
            }
            if (Schema::hasColumn('cursos', 'review_status')) {
                $table->dropColumn('review_status');
            }
        });
    }
};

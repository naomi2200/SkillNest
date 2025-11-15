<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (!Schema::hasColumn('mentorias', 'mentor_id')) {
                $table->foreignId('mentor_id')->after('id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('mentorias', 'estudiante_id')) {
                $table->foreignId('estudiante_id')->after('mentor_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('mentorias', 'titulo')) {
                $table->string('titulo')->after('estudiante_id');
            }

            if (!Schema::hasColumn('mentorias', 'descripcion')) {
                $table->text('descripcion')->after('titulo');
            }

            if (!Schema::hasColumn('mentorias', 'estado')) {
                $table->enum('estado', ['pendiente', 'confirmada', 'completada', 'cancelada'])
                    ->default('pendiente')
                    ->after('descripcion');
            }

            if (!Schema::hasColumn('mentorias', 'fecha_solicitud')) {
                $table->timestamp('fecha_solicitud')->nullable()->after('estado');
            }

            if (!Schema::hasColumn('mentorias', 'fecha_mentoria')) {
                $table->timestamp('fecha_mentoria')->nullable()->after('fecha_solicitud');
            }

            if (!Schema::hasColumn('mentorias', 'duracion_minutos')) {
                $table->integer('duracion_minutos')->default(60)->after('fecha_mentoria');
            }

            if (!Schema::hasColumn('mentorias', 'objetivos')) {
                $table->text('objetivos')->nullable()->after('duracion_minutos');
            }

            if (!Schema::hasColumn('mentorias', 'notas')) {
                $table->text('notas')->nullable()->after('objetivos');
            }

            if (!Schema::hasColumn('mentorias', 'precio')) {
                $table->decimal('precio', 8, 2)->default(0)->after('notas');
            }

            if (!Schema::hasColumn('mentorias', 'modalidad')) {
                $table->enum('modalidad', ['virtual', 'presencial'])->default('virtual')->after('precio');
            }

            if (!Schema::hasColumn('mentorias', 'enlace_reunion')) {
                $table->string('enlace_reunion')->nullable()->after('modalidad');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mentorias', function (Blueprint $table) {
            if (Schema::hasColumn('mentorias', 'mentor_id')) {
                $table->dropForeign(['mentor_id']);
                $table->dropColumn('mentor_id');
            }

            if (Schema::hasColumn('mentorias', 'estudiante_id')) {
                $table->dropForeign(['estudiante_id']);
                $table->dropColumn('estudiante_id');
            }

            $columns = [
                'titulo',
                'descripcion',
                'estado',
                'fecha_solicitud',
                'fecha_mentoria',
                'duracion_minutos',
                'objetivos',
                'notas',
                'precio',
                'modalidad',
                'enlace_reunion',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('mentorias', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

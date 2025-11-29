<?php
    use Illuminate\Support\Str;

    $profile = $mentor->mentorProfile;
    $mentoria = $mentoria ?? null;
    $skills = array_filter(array_map('trim', explode(',', (string) ($profile->skills ?? ''))));
    $categories = array_filter(array_map('trim', explode(',', (string) ($profile->categorias ?? ''))));
    $mentoriaPrice = optional($mentoria)->precio ?? 0;
    $mentoriaDuration = optional($mentoria)->duracion_minutos ?? 60;
    $mentoriaSpecialty = optional($mentoria)->especialidad ?? 'Generalista';
    $mentoriaModalidad = $mentoria && $mentoria->modalidad ? ucfirst($mentoria->modalidad) : 'Modalidad no definida';
    $experienceLabels = [
        'junior' => 'Junior (0-2 años)',
        'mid' => 'Intermedio (3-6 años)',
        'senior' => 'Senior (7+ años)',
    ];
    $experienceLabel = $profile->nivel_experiencia
        ? ($experienceLabels[$profile->nivel_experiencia] ?? ucfirst($profile->nivel_experiencia))
        : 'Nivel no especificado';
?>

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary: #7c3aed;
            --primary-2: #8b5cf6;
        }
        body {
            background: radial-gradient(circle at 15% 20%, rgba(124,58,237,0.08), transparent 30%),
                        radial-gradient(circle at 80% 0%, rgba(124,58,237,0.08), transparent 30%),
                        #f5f3ff;
        }
        .page-shell { max-width: 1180px; margin: 0 auto; padding: 32px 16px 64px; }
        .hero-card {
            background: #fff;
            border-radius: 30px;
            padding: 28px;
            border: 1px solid rgba(124,58,237,0.1);
            box-shadow: 0 24px 60px rgba(124,58,237,0.12);
        }
        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(124,58,237,0.08);
            color: #6d28d9;
            font-weight: 700;
            font-size: 12px;
        }
        .avatar {
            width: 78px;
            height: 78px;
            border-radius: 22px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(124,58,237,0.08);
            color: #6d28d9;
            font-weight: 700;
            font-size: 13px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(160px,1fr));
            gap: 12px;
            margin-top: 16px;
        }
        .meta-card {
            background: #f8fafc;
            border: 1px solid rgba(124,58,237,0.08);
            border-radius: 14px;
            padding: 12px 14px;
        }
        .meta-card p { margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.12em; color: #94a3b8; }
        .meta-card strong { display: block; margin-top: 4px; font-size: 15px; color: #1f2937; }

        .section-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(124,58,237,0.08);
            box-shadow: 0 16px 40px rgba(124,58,237,0.08);
            padding: 22px;
        }
        .section-card h2 { font-size: 18px; font-weight: 800; color: #1f2937; margin-bottom: 10px; }
        .section-card h3 { font-size: 16px; font-weight: 800; color: #1f2937; margin-top: 14px; }
        .chip {
            display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px;
            background: rgba(124,58,237,0.1); color:#6d28d9; font-weight:700; font-size:12px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            border: none;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 10px 28px rgba(124,58,237,0.18);
        }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .info-table td { padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; color: #1f2937; }
        .info-table td:first-child { color: #6b7280; width: 45%; font-weight: 600; }
        .form-label { display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:6px; }
        .form-input {
            width: 100%; border:1px solid #e5e7eb; border-radius:12px; padding:10px 12px;
            background:#fff; color:#111827;
        }
        .form-input:focus { outline: 2px solid rgba(124,58,237,0.3); border-color: rgba(124,58,237,0.5); }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-shell">
        <div class="hero-card">
            <div class="flex flex-wrap items-center gap-4">
                <div class="avatar"><?php echo e(strtoupper(Str::substr($mentor->name, 0, 1))); ?></div>
                <div class="flex-1 space-y-1">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Mentor verificado</p>
                    <h1 class="text-3xl font-black text-slate-900"><?php echo e($mentor->name); ?></h1>
                    <p class="text-base text-slate-600"><?php echo e($mentoriaSpecialty); ?></p>
                    <div class="flex flex-wrap gap-2 text-sm text-slate-600 mt-1">
                        <span class="pill">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <?php echo e($profile->experiencia_anios ?? 0); ?> años de experiencia
                        </span>
                        <span class="pill">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.4 12.545.8 8.41l6.09-.885L10 2l3.11 5.525 6.09.885-4.6 4.137 1.278 5.545z"/></svg>
                            <?php echo e(number_format($mentor->rating ?? 4.8, 1)); ?> · <?php echo e($mentor->sessions_count ?? 0); ?> sesiones
                        </span>
                    </div>
                </div>
                <div class="min-w-[220px] rounded-2xl border border-slate-100 bg-slate-50 px-5 py-4 text-right">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Tarifa por sesión</p>
                    <p class="mt-1 text-3xl font-black text-slate-900">
                        S/ <?php echo e(number_format($mentoriaPrice, 2)); ?>

                        <span class="text-base font-medium text-slate-500">/ <?php echo e($mentoriaDuration); ?> min</span>
                    </p>
                    <p class="text-sm text-slate-600">Modalidad: <?php echo e($mentoriaModalidad); ?></p>
                    <div class="meta-grid" style="margin-top:12px;">
                        <div class="meta-card">
                            <p>Nivel</p>
                            <strong><?php echo e($experienceLabel); ?></strong>
                        </div>
                        <div class="meta-card">
                            <p>Especialidad</p>
                            <strong><?php echo e($mentoriaSpecialty); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.6fr_1fr] mt-6">
            <section class="section-card space-y-5">
                <div>
                    <h2>Acerca de mí</h2>
                    <p class="text-slate-600"><?php echo e($profile->descripcion ?? 'Este mentor aún no ha completado su biografía.'); ?></p>
                </div>

                <div>
                    <h3>Detalles de la mentoría</h3>
                    <table class="info-table">
                        <tr><td>Precio</td><td>S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></td></tr>
                        <tr><td>Duración</td><td><?php echo e($mentoriaDuration); ?> min</td></tr>
                        <tr><td>Modalidad</td><td><?php echo e($mentoriaModalidad); ?></td></tr>
                        <tr><td>Especialidad</td><td><?php echo e($mentoriaSpecialty); ?></td></tr>
                        <tr><td>Nivel de experiencia</td><td><?php echo e($experienceLabel); ?></td></tr>
                    </table>
                </div>

                <div>
                    <h3>Habilidades</h3>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="chip"><?php echo e($skill); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Aún no hay habilidades registradas.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3>Categorías destacadas</h3>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="chip"><?php echo e($category); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Este mentor aún no define categorías.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3>Cursos dictados</h3>
                    <div class="mt-3 grid gap-3 md:grid-cols-2">
                        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <article class="rounded-2xl border border-slate-100 p-4">
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo e($course->category ?? 'Curso'); ?></p>
                                <h4 class="mt-1 text-lg font-semibold text-slate-900"><?php echo e($course->title ?? $course->name); ?></h4>
                                <p class="mt-2 text-sm text-slate-600 line-clamp-3"><?php echo e($course->description ?? 'Detalles no disponibles.'); ?></p>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Este mentor aún no tiene cursos públicos.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <aside id="booking" class="section-card space-y-4">
                <h2>Agenda tu mentoría</h2>
                <p class="text-sm text-slate-600">Sesiones personalizadas de <?php echo e($mentoriaDuration); ?> minutos. Comparte tus objetivos y define un plan con tu mentor.</p>

                <?php if(!auth()->check()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-gradient w-full justify-center">Inicia sesión para agendar</a>
                <?php elseif(auth()->user()->isMentor()): ?>
                    <div class="rounded-2xl border border-dashed border-slate-200 p-4 text-sm text-slate-500">
                        Inicia sesión como estudiante para reservar una sesión.
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('mentor-market.book', $mentor)); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="form-label">Fecha</label>
                            <input type="date" name="date" class="form-input" min="<?php echo e(now()->toDateString()); ?>" required>
                        </div>
                        <div>
                            <label class="form-label">Hora</label>
                            <input type="time" name="time" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Notas para el mentor</label>
                            <textarea name="notes" class="form-input" rows="3" placeholder="Cuéntale tus objetivos o contexto."></textarea>
                        </div>

                        <?php
                            $serviceFee = round($mentoriaPrice * 0.05, 2);
                            $total = $mentoriaPrice + $serviceFee;
                        ?>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4 text-sm text-slate-600">
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt>Precio por sesión</dt>
                                    <dd class="font-semibold text-slate-900">S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Servicio SkillNest (5%)</dt>
                                    <dd class="font-semibold text-slate-900">S/ <?php echo e(number_format($serviceFee, 2)); ?></dd>
                                </div>
                                <div class="flex justify-between text-base font-semibold text-slate-900">
                                    <dt>Total estimado</dt>
                                    <dd>S/ <?php echo e(number_format($total, 2)); ?></dd>
                                </div>
                            </dl>
                        </div>

                        <button class="btn-gradient w-full justify-center" type="submit">Agendar sesión</button>
                    </form>
                <?php endif; ?>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/mentor-market/show.blade.php ENDPATH**/ ?>
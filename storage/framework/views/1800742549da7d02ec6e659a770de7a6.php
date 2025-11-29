

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

<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-6xl space-y-8">
        <section class="rounded-[40px] border border-slate-100 bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 p-[1px] text-white shadow-card">
            <div class="rounded-[38px] bg-slate-900/75 px-8 py-8 backdrop-blur">
                <div class="flex flex-wrap items-center gap-8">
                    <div class="flex h-28 w-28 items-center justify-center rounded-[30px] bg-white/10 text-4xl font-bold uppercase">
                        <?php echo e(strtoupper(Str::substr($mentor->name, 0, 1))); ?>

                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-xs uppercase tracking-[0.6em] text-white/70">Mentor verificado</p>
                        <h1 class="text-4xl font-semibold"><?php echo e($mentor->name); ?></h1>
                        <p class="text-lg text-white/80"><?php echo e($mentoriaSpecialty); ?></p>
                        <div class="flex flex-wrap gap-4 text-sm text-white/80">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09L5.4 12.545.8 8.41l6.09-.885L10 2l3.11 5.525 6.09.885-4.6 4.137 1.278 5.545z"/></svg>
                                <strong class="text-white"><?php echo e(number_format($mentor->rating ?? 4.8, 1)); ?></strong>
                                <span><?php echo e($mentor->sessions_count ?? 0); ?> sesiones</span>
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <?php echo e($profile->experiencia_anios ?? 0); ?> años de experiencia
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100/20 px-4 py-1 text-emerald-200">
                                Disponible para mentorías
                            </span>
                        </div>
                    </div>
                    <div class="rounded-[24px] border border-white/10 bg-white/5 px-6 py-5 text-right shadow-inner">
                        <p class="text-xs uppercase tracking-[0.4em] text-white/70">Tarifa por sesión</p>
                        <p class="mt-1 text-3xl font-semibold text-white">
                            S/ <?php echo e(number_format($mentoriaPrice, 2)); ?>

                            <span class="text-base font-normal text-white/70">/ <?php echo e($mentoriaDuration); ?> min</span>
                        </p>
                        <p class="text-sm text-white/70">Modalidad: <?php echo e($mentoriaModalidad); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-3">
            <section class="space-y-6 rounded-[32px] border border-slate-100 bg-white/95 p-6 shadow-card lg:col-span-2">
                <div>
                    <h2 class="text-xl font-semibold text-secondary">Acerca de mí</h2>
                    <p class="mt-3 text-slate-600"><?php echo e($profile->descripcion ?? 'Este mentor aún no ha completado su biografía.'); ?></p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-secondary">Especialidad principal</h3>
                    <p class="mt-2 text-slate-600"><?php echo e($mentoriaSpecialty); ?></p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3 text-sm text-slate-600">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Precio</p>
                            <p class="mt-1 text-base font-semibold text-secondary">S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Duración</p>
                            <p class="mt-1 font-semibold text-secondary"><?php echo e($mentoriaDuration); ?> min</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Modalidad</p>
                            <p class="mt-1 font-semibold text-secondary"><?php echo e($mentoriaModalidad); ?></p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-secondary">Habilidades</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary"><?php echo e($skill); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Aún no hay habilidades registradas.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-secondary">Nivel de experiencia</h3>
                    <p class="mt-2 text-slate-600"><?php echo e($experienceLabel); ?></p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-secondary">Categorías destacadas</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="rounded-full bg-secondary/10 px-3 py-1 text-xs font-semibold text-secondary"><?php echo e($category); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Este mentor aún no define categorías.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-secondary">Cursos dictados</h3>
                    <div class="mt-3 grid gap-3 md:grid-cols-2">
                        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <article class="rounded-2xl border border-slate-100 p-4">
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo e($course->category ?? 'Curso'); ?></p>
                                <h4 class="mt-1 text-lg font-semibold text-secondary"><?php echo e($course->title ?? $course->name); ?></h4>
                                <p class="mt-2 text-sm text-slate-500 line-clamp-3"><?php echo e($course->description ?? 'Detalles no disponibles.'); ?></p>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Este mentor aún no tiene cursos públicos.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <aside id="booking" class="space-y-4 rounded-[32px] border border-slate-100 bg-white/95 p-6 shadow-card">
                <h3 class="text-xl font-semibold text-secondary">Agenda tu mentoría</h3>
                <p class="text-sm text-slate-500">Sesiones personalizadas. Comparte tus objetivos y define un plan con tu mentor.</p>

                <?php if(!auth()->check()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-primary w-full justify-center">Inicia sesión para agendar</a>
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
                                    <dd class="font-semibold text-secondary">S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Servicio SkillNest (5%)</dt>
                                    <dd class="font-semibold text-secondary">S/ <?php echo e(number_format($serviceFee, 2)); ?></dd>
                                </div>
                                <div class="flex justify-between text-base font-semibold text-secondary">
                                    <dt>Total estimado</dt>
                                    <dd>S/ <?php echo e(number_format($total, 2)); ?></dd>
                                </div>
                            </dl>
                        </div>

                        <button class="btn-gradient w-full justify-center">Agendar sesión</button>
                    </form>
                <?php endif; ?>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/mentor-market/show.blade.php ENDPATH**/ ?>
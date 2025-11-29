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
        'junior' => 'Junior (0-2 anios)',
        'mid' => 'Mid (3-6 anios)',
        'senior' => 'Senior (7+ anios)',
    ];
    $experienceLabel = $profile->nivel_experiencia
        ? ($experienceLabels[$profile->nivel_experiencia] ?? ucfirst($profile->nivel_experiencia))
        : 'Nivel no especificado';
?>

<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-5xl space-y-8">
        <div class="rounded-[32px] border border-slate-100 bg-white/95 p-8 shadow-card">
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex h-24 w-24 items-center justify-center rounded-[24px] bg-primary/10 text-4xl font-bold text-primary">
                    <?php echo e(strtoupper(Str::substr($mentor->name, 0, 1))); ?>

                </div>
                <div class="flex-1 space-y-1">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Mentor verificado</p>
                    <h1 class="text-4xl font-semibold text-secondary"><?php echo e($mentor->name); ?></h1>
                    <p class="text-lg text-slate-500"><?php echo e($mentoriaSpecialty); ?></p>
                </div>
                <div class="space-y-2 text-right">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Tarifa por sesi?n</p>
                    <p class="text-3xl font-semibold text-secondary">
                        S/ <?php echo e(number_format($mentoriaPrice, 2)); ?>

                        <span class="text-base font-normal text-slate-400">/ <?php echo e($mentoriaDuration); ?> min</span>
                    </p>
                    <p class="text-sm text-slate-500">Modalidad: <?php echo e($mentoriaModalidad); ?></p>
                    <p class="text-sm text-slate-500"><?php echo e($profile->experiencia_anios ?? 0); ?> a?os de experiencia</p>
                </div>
            </div>
        </div>

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
                    <h3 class="text-lg font-semibold text-secondary">Categorias destacadas</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <span class="rounded-full bg-secondary/10 px-3 py-1 text-xs font-semibold text-secondary"><?php echo e($category); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-slate-500">Este mentor aun no define categorias.</p>
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
                <h3 class="text-xl font-semibold text-secondary">Agendar sesión</h3>
                <p class="text-sm text-slate-500">Sesiones virtuales de 60 minutos. Comparte tus objetivos y agenda una cita.</p>

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
                            <div class="flex justify-between">
                                <span>Precio por sesión</span>
                                <strong class="text-secondary">S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></strong>
                            </div>
                            <div class="mt-2 flex justify-between">
                                <span>Servicio SkillNest (5%)</span>
                                <strong class="text-secondary">S/ <?php echo e(number_format($serviceFee, 2)); ?></strong>
                            </div>
                            <div class="mt-3 flex justify-between text-base font-semibold text-secondary">
                                <span>Total estimado</span>
                                <span>S/ <?php echo e(number_format($total, 2)); ?></span>
                            </div>
                        </div>

                        <button class="btn-gradient w-full justify-center">Agendar sesión</button>
                    </form>
                <?php endif; ?>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/mentor-market/show.blade.php ENDPATH**/ ?>
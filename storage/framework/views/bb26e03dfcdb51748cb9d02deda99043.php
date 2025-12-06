<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-6xl space-y-8 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-slate-400">Aula virtual</p>
                <h1 class="text-3xl font-bold text-secondary"><?php echo e($course->title); ?></h1>
                <p class="text-sm text-slate-500">Progreso personalizado para <?php echo e(auth()->user()->name); ?></p>
            </div>
            <a href="<?php echo e(route('cursos.show', $course->id)); ?>" class="btn-secondary rounded-full px-6">Volver al curso</a>
        </div>

        <div class="rounded-[28px] border border-slate-100 bg-white shadow-card">
            <div class="grid gap-8 p-6 lg:grid-cols-3">
                <div class="space-y-4 lg:col-span-2">
                    <?php $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $moduleKey = "module_{$module->id}_lesson_";
                            $moduleProgress = $progress->filter(fn($value, $key) => str_contains($key, "module_{$module->id}_lesson_"));
                            $completedLessons = $moduleProgress->filter(fn($records) => optional($records->first())->status === 'completed')->count();
                            $totalLessons = $module->lessons->count();
                            $moduleUnlocked = $progress->has("module_{$module->id}_lesson_");
                        ?>
                        <article class="rounded-2xl border border-slate-100 p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm uppercase tracking-wide text-slate-400">Módulo <?php echo e($loop->iteration); ?></p>
                                    <h2 class="text-xl font-semibold text-secondary"><?php echo e($module->title); ?></h2>
                                </div>
                                <span class="badge <?php echo e($moduleUnlocked ? 'bg-success/10 text-success' : 'bg-slate-100 text-slate-500'); ?>">
                                    <?php echo e($moduleUnlocked ? 'Desbloqueado' : 'Bloqueado'); ?>

                                </span>
                            </div>
                            <p class="mt-2 text-sm text-slate-500"><?php echo e($module->description); ?></p>

                            <div class="mt-4 space-y-2">
                                <?php $__currentLoopData = $module->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $key = "module_{$module->id}_lesson_{$lesson->id}";
                                        $lessonProgress = optional($progress->get($key)[0] ?? null);
                                        $status = $lessonProgress->status ?? 'locked';
                                    ?>
                                    <div class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-3">
                                        <div>
                                            <p class="text-sm font-semibold text-secondary"><?php echo e($lesson->title); ?></p>
                                            <p class="text-xs text-slate-500"><?php echo e(ucfirst($lesson->type)); ?> · <?php echo e($lesson->duration_minutes ?? 10); ?> min</p>
                                        </div>
                                        <button
                                            class="text-sm font-semibold <?php echo e($status === 'completed' ? 'text-success' : 'text-primary'); ?>"
                                            <?php if($moduleUnlocked): ?> data-lesson="<?php echo e($lesson->id); ?>" data-status="<?php echo e($status); ?>" class="start-lesson btn-secondary" <?php endif; ?>
                                        >
                                            <?php echo e($status === 'completed' ? 'Completado' : 'Iniciar'); ?>

                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border border-slate-100 p-5">
                        <h3 class="text-lg font-semibold text-secondary">Notas del curso</h3>
                        <p class="mt-3 text-sm text-slate-500">
                            Completa cada módulo y aprueba el quiz final para desbloquear el siguiente. Tu progreso se guarda automáticamente.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 p-5">
                        <h3 class="text-lg font-semibold text-secondary">Soporte</h3>
                        <p class="mt-3 text-sm text-slate-500">¿Necesitas ayuda? Escribe a soporte@skillnest.com con el nombre del curso.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.start-lesson').forEach(button => {
            button.addEventListener('click', () => {
                const lessonId = button.dataset.lesson;
                fetch(`/lessons/${lessonId}/progress`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'completed' })
                }).then(() => window.location.reload());
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/courses/classroom.blade.php ENDPATH**/ ?>
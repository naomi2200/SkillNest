<?php $__env->startSection('mentor-title', 'Mis estudiantes'); ?>
<?php $__env->startSection('mentor-subtitle', 'Personas inscritas en tus cursos Lovable'); ?>

<?php $__env->startSection('mentor-content'); ?>
    <div class="card">
        <h2 class="text-xl font-semibold text-secondary">Estudiantes inscritos en tus cursos</h2>
        <p class="text-sm text-slate-500">Haz seguimiento del avance y progreso.</p>

        <div class="mt-6 space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-lg font-semibold text-secondary"><?php echo e($student->name); ?></p>
                            <p class="text-sm text-slate-500"><?php echo e($student->email); ?></p>
                        </div>
                        <span class="badge bg-primary/10 text-primary"><?php echo e($student->courses_count); ?> cursos</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        Última actividad: <?php echo e(optional($student->last_activity_at)->diffForHumans() ?? 'Sin actividad reciente'); ?>

                    </p>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no tienes estudiantes asignados.
                </p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/dashboard/mentor/students.blade.php ENDPATH**/ ?>
<?php $__env->startSection('student-title', 'Mis cursos'); ?>
<?php $__env->startSection('student-subtitle', 'Encuentra los cursos que has adquirido'); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-lg font-semibold text-secondary">Cursos activos</h2>
            <span class="text-sm text-slate-500"><?php echo e($courses->count()); ?> cursos</span>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="rounded-3xl border border-slate-100 bg-white/80 p-5 shadow-card">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo e($course->category); ?></p>
                    <h3 class="mt-1 text-xl font-semibold text-secondary"><?php echo e($course->title); ?></h3>
                    <p class="text-sm text-slate-500">Nivel <?php echo e(ucfirst($course->level)); ?> · <?php echo e($course->lessons_count ?? 0); ?> lecciones</p>

                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span>Progreso</span>
                        <span class="font-semibold text-secondary"><?php echo e($course->pivot->progress ?? 0); ?>%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-primary" style="width: <?php echo e($course->pivot->progress ?? 0); ?>%;"></div>
                    </div>

                    <div class="mt-5 flex gap-3">
                        <a href="<?php echo e(route('courses.classroom', $course)); ?>"
                           class="btn-primary flex-1 justify-center">Continuar</a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="rounded-3xl border border-dashed border-slate-200 p-10 text-center text-slate-500 md:col-span-2">
                    Aún no tienes cursos inscritos.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/student/courses/index.blade.php ENDPATH**/ ?>
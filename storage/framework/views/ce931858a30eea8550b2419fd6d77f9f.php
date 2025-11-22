<?php $__env->startSection('dashboard-title', 'Panel principal'); ?>

<?php $__env->startSection('dashboard-actions'); ?>
    <div class="flex gap-3">
        <form action="<?php echo e(route('cursos.create-draft')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-primary">Nuevo curso</button>
        </form>
        <a href="<?php echo e(route('mentorias.create')); ?>" class="btn-secondary">Nueva mentoría</a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-widgets'); ?>
    <div class="card">
        <p class="text-sm uppercase tracking-wide text-slate-400">Cursos activos</p>
        <p class="mt-2 text-4xl font-bold text-secondary"><?php echo e($stats['courses_active'] ?? 0); ?></p>
        <p class="mt-1 text-sm text-slate-500">Cursos publicados y visibles para estudiantes</p>
    </div>
    <div class="card">
        <p class="text-sm uppercase tracking-wide text-slate-400">Mentorías agendadas</p>
        <p class="mt-2 text-4xl font-bold text-secondary"><?php echo e($stats['mentorships_upcoming'] ?? 0); ?></p>
        <p class="mt-1 text-sm text-slate-500">Sesiones confirmadas para los próximos 7 días</p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-content'); ?>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Últimos cursos</h2>
                <a href="<?php echo e(route('cursos.index')); ?>" class="text-sm font-medium text-primary">Ver todos</a>
            </div>
            <ul class="mt-4 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $recentCourses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="rounded-lg border border-slate-100 px-4 py-3">
                        <p class="font-semibold text-secondary"><?php echo e($course->title); ?></p>
                        <p class="text-sm text-slate-500"><?php echo e($course->category); ?> · <?php echo e($course->level); ?></p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="rounded-lg border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                        Aún no tienes cursos registrados.
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="card">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-secondary">Próximas mentorías</h2>
                <a href="<?php echo e(route('mentorias.index')); ?>" class="text-sm font-medium text-primary">Ver agenda</a>
            </div>
            <ul class="mt-4 space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingMentorships ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="rounded-lg border border-slate-100 px-4 py-3">
                        <p class="font-semibold text-secondary"><?php echo e($session->title); ?></p>
                        <p class="text-sm text-slate-500">
                            <?php if($session->scheduled_at): ?>
                                <?php echo e($session->scheduled_at->format('d M, H:i')); ?>

                            <?php else: ?>
                                Sin fecha programada
                            <?php endif; ?>
                        </p>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="rounded-lg border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">
                        No hay sesiones programadas todavía.
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/dashboard/index.blade.php ENDPATH**/ ?>
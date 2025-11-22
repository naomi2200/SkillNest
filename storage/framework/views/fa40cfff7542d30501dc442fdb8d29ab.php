<?php $__env->startSection('mentor-title', 'Mis cursos'); ?>
<?php $__env->startSection('mentor-subtitle', 'Gestiona y publica tus experiencias Lovable'); ?>

<?php $__env->startSection('mentor-actions'); ?>
    <form action="<?php echo e(route('cursos.create-draft')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn-gradient rounded-full px-6">Crear curso</button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mentor-content'); ?>
    <div class="rounded-3xl border border-slate-100 bg-white shadow-card">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="py-3">Curso</th>
                    <th class="py-3">Inscritos</th>
                    <th class="py-3">Revisión</th>
                    <th class="py-3">Estado</th>
                    <th class="py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="py-4">
                            <p class="font-semibold text-secondary"><?php echo e($course->title); ?></p>
                            <p class="text-xs text-slate-500"><?php echo e($course->category); ?> · <?php echo e($course->level); ?></p>
                        </td>
                        <td class="py-4 text-slate-600"><?php echo e($course->estudiantes_count ?? 0); ?></td>
                        <td class="py-4">
                            <span class="badge <?php echo e($course->review_status === 'approved' ? 'bg-success/10 text-success' : ($course->review_status === 'pending' ? 'bg-warning/10 text-warning' : 'bg-slate-100 text-slate-500')); ?>">
                                <?php echo e(ucfirst($course->review_status)); ?>

                            </span>
                        </td>
                        <?php
                            $statusColors = [
                                'borrador' => 'bg-slate-100 text-slate-500',
                                'pendiente' => 'bg-warning/10 text-warning',
                                'aprobado' => 'bg-success/10 text-success',
                                'rechazado' => 'bg-rose-100 text-rose-600',
                            ];
                        ?>
                        <td class="py-4">
                            <span class="badge <?php echo e($statusColors[$course->status] ?? 'bg-slate-100 text-slate-500'); ?>">
                                <?php echo e(ucfirst($course->status)); ?>

                            </span>
                        </td>
                        <td class="py-4 text-right space-x-2">
                            <a href="<?php echo e(route('cursos.editor', $course)); ?>" class="text-sm font-semibold text-primary hover:text-primary/80">Editar</a>
                            <a href="<?php echo e(route('courses.classroom', $course)); ?>" class="text-sm text-slate-500 hover:text-secondary">Aula</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-6 text-center text-sm text-slate-500">
                            Aún no has creado cursos.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/dashboard/mentor/courses.blade.php ENDPATH**/ ?>
<?php $__env->startSection('mentor-title', 'Mis cursos'); ?>
<?php $__env->startSection('mentor-subtitle', 'Gestiona y publica tus experiencias Lovable'); ?>

<?php $__env->startSection('mentor-actions'); ?>
    <form action="<?php echo e(route('cursos.create-draft')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="mentor-btn primary">+ Crear curso</button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mentor-content'); ?>
    <?php
        $draftCount = $courses->where('status', 'borrador')->count();
        $pendingCount = $courses->where('status', 'pendiente')->count();
        $approvedCount = $courses->where('status', 'aprobado')->count();
    ?>

    <div class="mentor-card" style="margin-bottom: 24px;">
        <div class="mentor-stats-grid" style="display:grid;gap:18px;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));">
            <div class="mentor-stat-card">
                <p class="mentor-stat-label">Borradores</p>
                <p class="mentor-stat-value"><?php echo e($draftCount); ?></p>
                <small>En modo editor visual</small>
            </div>
            <div class="mentor-stat-card">
                <p class="mentor-stat-label">En revisión</p>
                <p class="mentor-stat-value" style="color:#b45309;"><?php echo e($pendingCount); ?></p>
                <small>Esperando aprobación</small>
            </div>
            <div class="mentor-stat-card">
                <p class="mentor-stat-label">Publicados</p>
                <p class="mentor-stat-value" style="color:#047857;"><?php echo e($approvedCount); ?></p>
                <small>Cursos activos</small>
            </div>
        </div>
    </div>

    <div class="mentor-card">
        <div class="mentor-table-wrapper">
            <table class="mentor-table">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Inscritos</th>
                    <th>Revisión</th>
                    <th>Estado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <strong><?php echo e($course->title); ?></strong>
                            <div style="font-size:12px;color:#94a3b8;"><?php echo e($course->category); ?> · <?php echo e($course->level); ?></div>
                        </td>
                        <td><?php echo e($course->estudiantes_count ?? 0); ?></td>
                        <td>
                            <?php
                                $reviewBadge = match($course->review_status) {
                                    'approved' => 'mentor-badge badge-approved',
                                    'pending' => 'mentor-badge badge-pending',
                                    'rejected' => 'mentor-badge badge-rejected',
                                    default => 'mentor-badge badge-draft',
                                };
                            ?>
                            <span class="<?php echo e($reviewBadge); ?>"><?php echo e(ucfirst($course->review_status ?? 'pendiente')); ?></span>
                        </td>
                        <td>
                            <?php
                                $statusBadge = match($course->status) {
                                    'borrador' => 'mentor-badge badge-draft',
                                    'pendiente' => 'mentor-badge badge-pending',
                                    'aprobado' => 'mentor-badge badge-approved',
                                    'rechazado' => 'mentor-badge badge-rejected',
                                    default => 'mentor-badge badge-draft',
                                };
                            ?>
                            <span class="<?php echo e($statusBadge); ?>"><?php echo e(ucfirst($course->status)); ?></span>
                        </td>
                        <td style="text-align:right;">
                            <a href="<?php echo e(route('cursos.editor', $course)); ?>" style="margin-right:12px;color:#6c47ff;font-weight:600;text-decoration:none;">Editar</a>
                            <a href="<?php echo e(route('courses.classroom', $course)); ?>" style="color:#6b7280;font-weight:500;text-decoration:none;">Aula</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;color:#94a3b8;padding:30px 0;">Aún no has creado cursos.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/dashboard/mentor/courses.blade.php ENDPATH**/ ?>
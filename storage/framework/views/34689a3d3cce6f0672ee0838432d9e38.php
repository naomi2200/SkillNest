<?php
    $currentView = request()->query('view', 'solicitudes');
?>

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary: #6c47ff;
            --primary-light: #f0edff;
            --secondary: #1f2937;
            --accent: #8b5cf6;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --radius: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .dashboard-card.space-y-6 > * + * {margin-top:24px;}
        .table-header{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:20px;}
        .header-content{flex:1;min-width:300px;}
        .section-badge{font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;color:var(--gray-400);font-weight:600;margin-bottom:8px;}
        .section-title{font-size:1.5rem;font-weight:600;color:var(--secondary);margin-bottom:8px;}
        .section-description{color:var(--gray-500);font-size:.875rem;}
        .filter-form{display:flex;gap:12px;align-items:center;}
        .filter-select{padding:10px 16px;border:1px solid var(--gray-300);border-radius:var(--radius);background:var(--white);color:var(--gray-700);font-size:.875rem;min-width:140px;transition:.2s;}
        .filter-select:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px rgba(108,71,255,.1);}
        .filter-button{padding:10px 20px;background:var(--primary);color:var(--white);border:none;border-radius:var(--radius);font-weight:600;font-size:.875rem;cursor:pointer;transition:.2s;}
        .filter-button:hover{background:#5a38e6;transform:translateY(-1px);}
        .table-container{overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--gray-200);background:var(--white);}
        .data-table{width:100%;border-collapse:collapse;font-size:.875rem;}
        .data-table thead{background:var(--gray-50);border-bottom:1px solid var(--gray-200);}
        .data-table th{padding:16px 20px;text-align:left;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--gray-500);font-weight:600;white-space:nowrap;}
        .data-table tbody tr{border-bottom:1px solid var(--gray-100);transition:background-color .2s;}
        .data-table tbody tr:hover{background:var(--gray-50);}
        .data-table td{padding:16px 20px;color:var(--gray-700);vertical-align:top;}
        .course-title{font-weight:600;color:var(--secondary);margin-bottom:4px;line-height:1.4;}
        .course-category{font-size:.75rem;color:var(--gray-400);}
        .status-badge{display:inline-flex;align-items:center;padding:6px 12px;border-radius:20px;font-size:.75rem;font-weight:600;text-transform:capitalize;}
        .status-pendiente{background:rgba(245,158,11,.1);color:var(--warning);}
        .status-aprobado{background:rgba(16,185,129,.1);color:var(--success);}
        .status-rechazado{background:rgba(239,68,68,.1);color:var(--error);}
        .action-buttons{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap;}
        .btn-table{padding:6px 12px;border-radius:var(--radius);font-size:.75rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;transition:.2s;white-space:nowrap;}
        .btn-view{background:var(--gray-100);color:var(--gray-700);}
        .btn-view:hover{background:var(--gray-200);}
        .btn-approve{background:rgba(16,185,129,.1);color:var(--success);}
        .btn-approve:hover{background:var(--success);color:var(--white);}
        .btn-reject{background:rgba(239,68,68,.1);color:var(--error);}
        .btn-reject:hover{background:var(--error);color:var(--white);}
        .empty-state{text-align:center;padding:60px 20px;color:var(--gray-400);}
        @media (max-width:1024px){.table-header{flex-direction:column;align-items:stretch}.filter-form{justify-content:flex-start}}
        @media (max-width:768px){.filter-form{flex-direction:column;align-items:stretch}.table-container{border-radius:var(--radius)}.action-buttons{flex-direction:column}.btn-table{text-align:center}}
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('dashboard-content'); ?>
    <div class="dashboard-card space-y-6">
        <div class="table-header">
            <div class="header-content">
                <div class="section-badge">Gestión de cursos</div>
                <h2 class="section-title">
                    <?php echo e($currentView === 'tabla' ? 'Listado general' : 'Centro de solicitudes'); ?>

                </h2>
                <p class="section-description">
                    <?php if($currentView === 'tabla'): ?>
                        Consulta cursos publicados, rechazados y en revisión en formato tabla.
                    <?php else: ?>
                        Aprueba, rechaza o solicita cambios en un solo lugar.
                    <?php endif; ?>
                </p>
            </div>

            <form method="GET" class="filter-form">
                <input type="hidden" name="view" value="<?php echo e($currentView === 'tabla' ? 'tabla' : 'solicitudes'); ?>">
                <select name="status" class="filter-select">
                    <option value="pendiente" <?php if($currentStatus === 'pendiente'): echo 'selected'; endif; ?>>Pendientes</option>
                    <option value="aprobado" <?php if($currentStatus === 'aprobado'): echo 'selected'; endif; ?>>Aprobados</option>
                    <option value="rechazado" <?php if($currentStatus === 'rechazado'): echo 'selected'; endif; ?>>Rechazados</option>
                </select>
                <button class="filter-button">Filtrar</button>
            </form>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Mentor</th>
                    <th>Estado</th>
                    <th>Módulos</th>
                    <th>Actualizado</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="course-title"><?php echo e($course->title); ?></div>
                            <div class="course-category"><?php echo e($course->category ?? 'Sin categoría'); ?></div>
                        </td>
                        <td><?php echo e($course->mentor->name ?? 'Sin asignar'); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo e($course->status); ?>">
                                <?php echo e($course->status); ?>

                            </span>
                        </td>
                        <td><?php echo e($course->modules_count ?? 0); ?></td>
                        <td class="text-xs text-slate-500"><?php echo e(optional($course->updated_at)->diffForHumans() ?? 'N/A'); ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.courses.show', $course->id)); ?>" class="btn-table btn-view">Ver</a>
                                <?php if($course->status === 'pendiente'): ?>
                                    <form action="<?php echo e(route('admin.courses.approve', $course->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button class="btn-table btn-approve">Aprobar</button>
                                    </form>
                                    <form action="<?php echo e(route('admin.courses.reject', $course->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="rejection_reason" value="Curso rechazado desde la vista de tabla">
                                        <button class="btn-table btn-reject">Rechazar</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <p>No hay registros para el estado seleccionado.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div>
            <?php echo e($courses->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/admin/courses/index.blade.php ENDPATH**/ ?>
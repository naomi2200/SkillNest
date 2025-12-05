<?php $__env->startSection('admin-title', 'Panel general de SkillNest'); ?>
<?php $__env->startSection('admin-subtitle', 'Supervisa cursos en revisi&oacute;n, mentores y actividad de la comunidad'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .dashboard-hero {
        background: linear-gradient(135deg, rgba(108,71,255,0.08), rgba(139,92,246,0.12));
        border: 1px solid rgba(108,71,255,0.15);
        border-radius: 32px;
        padding: clamp(20px, 3vw, 32px);
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: space-between;
        align-items: center;
    }
    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .hero-meta span {
        font-size: .8rem;
        letter-spacing: .25em;
        text-transform: uppercase;
        color: #7c3aed;
        font-weight: 700;
    }
    .hero-meta h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
    }
    .hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        background: rgba(124,58,237,0.12);
        color: #5b21b6;
        font-weight: 600;
        font-size: .9rem;
    }
    .hero-user {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 10px 25px rgba(15,23,42,0.08);
    }
    .hero-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: linear-gradient(135deg,#7c3aed,#8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
    }
    .admin-actions .btn-action {
        border-radius: 18px;
        padding: 12px 24px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action.primary {
        background: linear-gradient(135deg,#7c3aed,#8b5cf6);
        color: #fff;
        box-shadow: 0 12px 25px rgba(124,58,237,0.25);
    }
    .btn-action.ghost {
        background: rgba(124,58,237,0.08);
        color: #5b21b6;
    }
    .stats-grid {
        margin-top: 32px;
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
        gap: 16px;
    }
    .stat-card {
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        border: 1px solid rgba(226,232,240,0.9);
    }
    .stat-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
        margin-bottom: 6px;
        display: block;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
    }
    .summary-grid {
        margin-top: 32px;
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
        gap: 20px;
    }
    .summary-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(226,232,240,0.9);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .summary-card h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
    }
    .summary-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .9rem;
        color: #475569;
    }
    .summary-item span:last-child {
        font-size: .8rem;
        color: #94a3b8;
    }
    .review-section {
        margin-top: 32px;
        background: #fff;
        border-radius: 28px;
        border: 1px solid rgba(226,232,240,0.9);
        padding: 24px;
    }
    .review-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
        align-items: center;
    }
    .review-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
    }
    .table-container {
        overflow-x: auto;
    }
    table.review-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .9rem;
    }
    .review-table thead {
        background: #f8fafc;
    }
    .review-table th,
    .review-table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(226,232,240,0.9);
        text-align: left;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-pendiente { background: rgba(245,158,11,0.15); color: #b45309; }
    .status-aprobado { background: rgba(16,185,129,0.18); color: #047857; }
    .status-rechazado { background: rgba(248,113,113,0.18); color: #b91c1c; }
    .table-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .table-actions form,
    .table-actions a {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .table-actions textarea {
        width: 100%;
        border: 1px solid rgba(226,232,240,0.9);
        border-radius: 10px;
        padding: 6px 10px;
        font-size: .8rem;
        resize: vertical;
    }
    .btn-table {
        border: none;
        border-radius: 12px;
        padding: 8px 14px;
        font-weight: 600;
        font-size: .8rem;
        cursor: pointer;
        text-align: center;
    }
    .btn-approve { background: rgba(16,185,129,0.15); color: #047857; }
    .btn-approve:hover { background: #10b981; color:#fff; }
    .btn-reject { background: rgba(248,113,113,0.15); color: #b91c1c; }
    .btn-reject:hover { background: #ef4444; color:#fff; }
    .btn-reset { background: rgba(59,130,246,0.15); color: #1d4ed8; }
    .btn-reset:hover { background: #3b82f6; color:#fff; }
    .empty-state {
        text-align: center;
        padding: 20px;
        color: #94a3b8;
    }
    @media (max-width: 768px) {
        .table-actions { flex-direction: column; }
        .table-actions form { width: 100%; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin-actions'); ?>
    <a href="<?php echo e(route('admin.courses.index', ['status' => 'pendiente', 'view' => 'solicitudes'])); ?>" class="btn-action primary">
        <i class="fa-solid fa-inbox"></i> Ver cursos pendientes
    </a>
    <a href="<?php echo e(route('admin.courses.index', ['view' => 'tabla', 'status' => 'pendiente'])); ?>" class="btn-action ghost">
        <i class="fa-solid fa-table"></i> Gestionar cursos
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
    <?php
        $pendingList = collect($pendingCourses ?? []);
        $recentCoursesList = collect($recentCourses ?? []);
        $recentMentoriasList = collect($recentMentorias ?? []);
        $recentUsersList = collect($recentUsers ?? []);
    ?>

    <section class="dashboard-hero">
        <div class="hero-meta">
            <span>Panel admin</span>
            <h2>Hola, <?php echo e(auth()->user()->name ?? 'Admin'); ?></h2>
            <p style="margin:0;color:#475569;">Mant&eacute;n el pulso de la comunidad y aprueba nuevos contenidos.</p>
            <span class="hero-pill">
                <i class="fa-solid fa-calendar"></i>
                <?php echo e(\Carbon\Carbon::now()->locale('es')->translatedFormat('l, d \d\e F')); ?>

            </span>
        </div>
        <div class="hero-user">
            <div>
                <strong><?php echo e(auth()->user()->name ?? 'Administrador'); ?></strong>
                <p style="margin:0;color:#6b7280;font-size:.9rem;"><?php echo e(auth()->user()->email ?? 'admin@skillnest.com'); ?></p>
            </div>
            <div class="hero-avatar"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?></div>
        </div>
    </section>

    <section class="stats-grid">
        <article class="stat-card">
            <span class="stat-label">Cursos activos</span>
            <span class="stat-value"><?php echo e(number_format($stats['courses_active'] ?? 0)); ?></span>
        </article>
        <article class="stat-card">
            <span class="stat-label">En revisi&oacute;n</span>
            <span class="stat-value"><?php echo e(number_format($stats['courses_pending'] ?? 0)); ?></span>
        </article>
        <article class="stat-card">
            <span class="stat-label">Borradores</span>
            <span class="stat-value"><?php echo e(number_format($stats['courses_drafts'] ?? 0)); ?></span>
        </article>
        <article class="stat-card">
            <span class="stat-label">Rechazados</span>
            <span class="stat-value"><?php echo e(number_format($stats['courses_rejected'] ?? 0)); ?></span>
        </article>
    </section>

    <section class="summary-grid">
        <article class="summary-card">
            <h3>Usuarios recientes</h3>
            <ul class="summary-list">
                <?php $__empty_1 = true; $__currentLoopData = $recentUsersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="summary-item">
                        <strong><?php echo e($user->name); ?></strong>
                        <span><?php echo e(ucfirst($user->role ?? 'usuario')); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="summary-item"><span>Sin registros</span></li>
                <?php endif; ?>
            </ul>
        </article>
        <article class="summary-card">
            <h3>Cursos publicados</h3>
            <ul class="summary-list">
                <?php $__empty_1 = true; $__currentLoopData = $recentCoursesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="summary-item">
                        <strong><?php echo e($course->title); ?></strong>
                        <span><?php echo e(optional($course->updated_at)->diffForHumans() ?? 'reciente'); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="summary-item"><span>Sin cursos recientes</span></li>
                <?php endif; ?>
            </ul>
        </article>
        <article class="summary-card">
            <h3>Mentor&iacute;as recientes</h3>
            <ul class="summary-list">
                <?php $__empty_1 = true; $__currentLoopData = $recentMentoriasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="summary-item">
                        <strong><?php echo e($mentoria->titulo ?? 'Sin t&iacute;tulo'); ?></strong>
                        <span><?php echo e(ucfirst($mentoria->estado ?? 'borrador')); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="summary-item"><span>Sin mentor&iacute;as publicadas</span></li>
                <?php endif; ?>
            </ul>
        </article>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
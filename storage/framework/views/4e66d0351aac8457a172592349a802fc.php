<?php
    $statusClasses = [
        'pendiente' => 'badge-pending',
        'aceptada' => 'badge-published',
        'confirmada' => 'badge-published',
        'rechazada' => 'badge-archived',
        'pagada' => 'badge-published',
        'completada' => 'badge-published',
        'cancelada' => 'badge-archived',
    ];

    $listMentorias = $mentorias ?? collect();
    if ($listMentorias->isEmpty()) {
        $listMentorias = collect();
        if (isset($createdMentorias)) {
            $listMentorias = $listMentorias->merge($createdMentorias);
        }
        if (isset($publishedMentorias)) {
            $listMentorias = $listMentorias->merge($publishedMentorias);
        }
        $listMentorias = $listMentorias->unique('id');
    }

    $draftCount = $listMentorias->where('estado', 'borrador')->count();
    $publishedCount = $listMentorias->where('estado', 'publicada')->count();
    $monthlyIncome = $ingresosDelMes ?? 0;
    $avgRating = $valoracionPromedio ?? 0;
?>

<?php $__env->startSection('mentor-title', 'Mis mentorías'); ?>
<?php $__env->startSection('mentor-subtitle', 'Define tus sesiones y tarifas personalizadas'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .mentor-shell .mentor-header,
    .mentor-shell .mentor-actions {
        display: none !important;
    }
    .mentorias-dashboard,
    .mentorias-dashboard * {
        font-family: 'Inter', sans-serif;
    }
    .mentorias-dashboard {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    .mentorias-header {
        background: #fff;
        border-radius: 24px;
        padding: 28px 32px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.04);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
    }
    .mentorias-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 6px;
        color: #1f2937;
    }
    .mentorias-header p {
        color: #6b7280;
    }
    .mentor-date {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(102,126,234,0.12);
        color: #4c1d95;
        font-weight: 600;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    .stats-card {
        background: #fff;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 15px 45px rgba(15,23,42,0.06);
        position: relative;
        overflow: hidden;
    }
    .stats-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(102,126,234,0.08), rgba(118,75,162,0.08));
        opacity: 0;
        transition: opacity .3s ease;
    }
    .stats-card:hover::before { opacity: 1; }
    .stats-card>* { position: relative; z-index: 1; }
    .stats-value {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1f2937;
    }
    .stats-label { color: #6b7280; font-weight: 600; }
    .stats-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(102,126,234,0.12);
        color: #6c47ff;
        font-size: 1.4rem;
    }
    .filter-bar {
        background: #fff;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 15px 45px rgba(15,23,42,0.05);
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .filter-btn {
        padding: 10px 22px;
        border-radius: 999px;
        border: 2px solid #e2e8f0;
        background: transparent;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
    }
    .filter-btn.active {
        background: linear-gradient(135deg,#667eea,#764ba2);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 15px 35px rgba(102,126,234,0.25);
    }
    .mentorias-grid {
        display: grid;
        gap: 24px;
    }
    .mentoria-card {
        background: #fff;
        border-radius: 26px;
        padding: 28px;
        box-shadow: 0 20px 60px rgba(15,23,42,0.08);
        border: 1px solid rgba(226,232,240,0.8);
    }
    .mentoria-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
        border-bottom: 1px solid rgba(226,232,240,0.7);
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .mentoria-card h3 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
    }
    .card-meta { color: #6b7280; }
    .price-block {
        text-align: right;
    }
    .price {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(160px,1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
    .info-item {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
    }
    .info-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #6b7280;
        font-weight: 600;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 700;
    }
    .badge-published { background: rgba(16,185,129,0.15); color: #047857; }
    .badge-draft { background: rgba(99,102,241,0.18); color: #4338ca; }
    .badge-pending { background: rgba(251,191,36,0.2); color: #92400e; }
    .badge-archived { background: rgba(248,113,113,0.18); color: #b91c1c; }
    .badge-virtual { background: rgba(79,172,254,0.18); color: #2563eb; }
    .badge-presencial { background: rgba(168,237,234,0.5); color: #0f172a; }
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .action-btn {
        border-radius: 12px;
        padding: 10px 18px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: .9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-edit { background: rgba(56,178,172,0.12); color: #0f766e; }
    .btn-publish { background: rgba(102,126,234,0.12); color: #4c1d95; }
    .btn-view { background: rgba(59,130,246,0.12); color: #1d4ed8; }
    .btn-delete { background: rgba(248,113,113,0.15); color: #b91c1c; }
    .mentoria-empty {
        text-align: center;
        padding: 60px 30px;
        border: 2px dashed #e2e8f0;
        border-radius: 26px;
        background: linear-gradient(135deg, #f8f9ff, #ffffff);
    }
    .requests-section {
        background: #fff;
        border-radius: 26px;
        padding: 28px;
        box-shadow: 0 20px 60px rgba(15,23,42,0.08);
    }
    .requests-grid {
        display: grid;
        gap: 20px;
        margin-top: 20px;
    }
    .request-card {
        border-radius: 24px;
        padding: 24px;
        border: 1px solid rgba(226,232,240,0.9);
        background: #f8fafc;
    }
    .request-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 16px;
    }
    .request-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(140px,1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    .request-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .request-actions .btn {
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 600;
        border: none;
    }
    .btn-request-accept { background: linear-gradient(135deg,#10b981,#34d399); color: #fff; }
    .btn-request-reject { background: rgba(248,113,113,0.15); color: #b91c1c; }
    .btn-request-neutral { background: rgba(102,126,234,0.12); color: #4c1d95; }
    @media (max-width: 768px) {
        .mentorias-header { flex-direction: column; align-items: flex-start; }
        .price-block { text-align: left; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('mentor-actions', ''); ?>


<?php $__env->startSection('mentor-content'); ?>
    <div class="mentorias-dashboard">
        <section class="mentorias-header">
            <div>
                <h1>Mis Mentorías</h1>
                <p>Define tus sesiones y tarifas personalizadas</p>
                <span class="mentor-date">
                    <i class="fa-solid fa-calendar"></i>
                    <span id="mentorMentoriasCurrentDate"></span>
                </span>
            </div>
            <a href="<?php echo e(route('mentorias.create')); ?>" class="btn btn-primary" style="border-radius: 12px;">
                <i class="fa-solid fa-plus"></i> Crear mentoría
            </a>
        </section>

        <section class="stats-grid">
            <article class="stats-card">
                <div class="flex justify-between items-center" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                    <div>
                        <p class="stats-value"><?php echo e($draftCount); ?></p>
                        <p class="stats-label">Borradores</p>
                    </div>
                    <div class="stats-icon"><i class="fa-solid fa-file"></i></div>
                </div>
                <p class="text-sm text-slate-500" style="margin-top:10px;">En modo editor</p>
            </article>
            <article class="stats-card">
                <div class="flex justify-between items-center" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                    <div>
                        <p class="stats-value"><?php echo e($publishedCount); ?></p>
                        <p class="stats-label">Publicadas</p>
                    </div>
                    <div class="stats-icon" style="background:rgba(16,185,129,0.15);color:#047857;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <p class="text-sm text-slate-500" style="margin-top:10px;">Listas para estudiantes</p>
            </article>
            <article class="stats-card">
                <div class="flex justify-between items-center" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                    <div>
                        <p class="stats-value">S/ <?php echo e(number_format($monthlyIncome, 0)); ?></p>
                        <p class="stats-label">Ingresos del mes</p>
                    </div>
                    <div class="stats-icon" style="background:rgba(251,191,36,0.2);color:#b45309;">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                </div>
                <p class="text-sm text-slate-500" style="margin-top:10px;">Total ganado</p>
            </article>
            <article class="stats-card">
                <div class="flex justify-between items-center" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
                    <div>
                        <p class="stats-value"><?php echo e(number_format($avgRating, 1)); ?></p>
                        <p class="stats-label">Valoración promedio</p>
                    </div>
                    <div class="stats-icon" style="background:rgba(244,114,182,0.2);color:#be185d;">
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <p class="text-sm text-slate-500" style="margin-top:10px;">Basado en reseñas</p>
            </article>
        </section>

        <section class="filter-bar">
            <button class="filter-btn active" data-filter="todas">Todas</button>
            <button class="filter-btn" data-filter="borrador">Borradores</button>
            <button class="filter-btn" data-filter="publicada">Publicadas</button>
            <button class="filter-btn" data-filter="virtual">Virtual</button>
            <button class="filter-btn" data-filter="presencial">Presencial</button>
        </section>

        <section class="mentorias-grid">
            <?php $__empty_1 = true; $__currentLoopData = $listMentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="mentoria-card" data-estado="<?php echo e($mentoria->estado); ?>" data-modalidad="<?php echo e($mentoria->modalidad); ?>">
                    <div class="card-header">
                        <div>
                            <h3><?php echo e($mentoria->titulo); ?></h3>
                            <p class="card-meta"><?php echo e(ucfirst($mentoria->categoria)); ?>  <?php echo e(ucfirst($mentoria->modalidad)); ?></p>
                        </div>
                        <div class="price-block">
                            <span class="badge <?php echo e($mentoria->estado === 'publicada' ? 'badge-published' : ($mentoria->estado === 'borrador' ? 'badge-draft' : 'badge-pending')); ?>">
                                <i class="fa-solid fa-circle"></i> <?php echo e(ucfirst($mentoria->estado)); ?>

                            </span>
                            <p class="price">S/ <?php echo e(number_format($mentoria->precio, 2)); ?></p>
                            <p class="text-sm text-slate-500">por sesión</p>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Duración</span>
                            <span class="info-value"><?php echo e($mentoria->duracion_minutos ?? $mentoria->duracion); ?> min</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Modalidad</span>
                            <span class="info-value">
                                <span class="badge <?php echo e($mentoria->modalidad === 'virtual' ? 'badge-virtual' : 'badge-presencial'); ?>">
                                    <?php echo e(ucfirst($mentoria->modalidad)); ?>

                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Sesiones/Creación</span>
                            <span class="info-value">
                                <?php if($mentoria->estado === 'publicada'): ?>
                                    <?php echo e($mentoria->sesiones_count ?? 0); ?> realizadas
                                <?php else: ?>
                                    <?php echo e(optional($mentoria->created_at)->format('d/m/Y')); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estado</span>
                            <span class="info-value"><?php echo e(ucfirst($mentoria->estado)); ?></span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="<?php echo e(route('mentorias.edit', $mentoria)); ?>" class="action-btn btn-edit">
                            <i class="fa-solid fa-pen"></i> Editar
                        </a>
                        <?php if($mentoria->estado === 'borrador'): ?>
                            <form action="<?php echo e(route('mentor.mentorias.publicar', $mentoria)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="action-btn btn-publish">
                                    <i class="fa-solid fa-rocket"></i> Publicar
                                </button>
                            </form>
                        <?php endif; ?>
                        <a href="<?php echo e(route('mentorias.show', $mentoria)); ?>" target="_blank" class="action-btn btn-view">
                            <i class="fa-solid fa-eye"></i> <?php echo e($mentoria->estado === 'borrador' ? 'Vista previa' : 'Ver público'); ?>

                        </a>
                        <?php if($mentoria->estado === 'borrador'): ?>
                            <form action="<?php echo e(route('mentor.mentorias.destroy', $mentoria)); ?>" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="action-btn btn-delete">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="mentoria-empty">
                    <div class="w-24 h-24 rounded-full" style="margin:0 auto 16px; background:linear-gradient(135deg,#f3e8ff,#e0e7ff); display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-chalkboard-teacher" style="font-size:2rem;color:#6b46c1;"></i>
                    </div>
                    <h3 class="text-xl font-semibold" style="color:#1f2937;">No tienes mentorías creadas</h3>
                    <p style="color:#6b7280;margin:12px auto 20px;max-width:360px;">Comienza a compartir tu experiencia creando mentorías personalizadas.</p>
                    <a href="<?php echo e(route('mentorias.create')); ?>" class="btn btn-primary" style="padding:12px 28px;border-radius:12px;display:inline-flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-plus"></i> Crear mi primera mentoría
                    </a>
                </div>
            <?php endif; ?>
        </section>

        <section class="requests-section">
            <div class="flex justify-between items-center" style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                <div>
                    <h2 class="text-xl font-semibold" style="color:#1f2937;">Solicitudes recibidas</h2>
                    <p class="text-sm" style="color:#6b7280;">Últimas solicitudes de tus mentorías publicadas</p>
                </div>
                <span class="text-sm" style="color:#94a3b8;"><?php echo e($stats['total'] ?? 0); ?> registro(s)</span>
            </div>

            <div class="requests-grid">
                <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $scheduleDate = $session->fecha_programada ?? $session->fecha_mentoria;
                        $scheduleTime = $session->hora_programada ?? optional($session->fecha_mentoria)?->format('H:i');
                        $amount = $session->monto ?? $session->precio;
                    ?>
                    <article class="request-card">
                        <div class="request-header">
                            <div>
                                <p class="text-sm" style="color:#6b7280;">Estudiante: <?php echo e($session->estudiante->name ?? 'No asignado'); ?></p>
                                <h4 style="font-size:1.15rem;font-weight:700;color:#1f2937;"><?php echo e($session->titulo); ?></h4>
                                <p class="text-xs" style="color:#94a3b8;">Solicitada <?php echo e(optional($session->fecha_solicitud)->format('d/m/Y H:i') ?? 'sin fecha'); ?></p>
                            </div>
                            <span class="badge <?php echo e($statusClasses[$session->estado] ?? 'badge-draft'); ?>">
                                <?php echo e(ucfirst($session->estado)); ?>

                            </span>
                        </div>

                        <div class="request-meta">
                            <div>
                                <span class="info-label">Fecha</span>
                                <span class="info-value"><?php echo e(optional($scheduleDate)->format('d/m/Y') ?? 'Por definir'); ?></span>
                            </div>
                            <div>
                                <span class="info-label">Hora</span>
                                <span class="info-value"><?php echo e($scheduleTime ?? 'Por definir'); ?></span>
                            </div>
                            <div>
                                <span class="info-label">Modalidad</span>
                                <span class="info-value"><?php echo e(ucfirst($session->modalidad)); ?></span>
                            </div>
                            <div>
                                <span class="info-label">Monto</span>
                                <span class="info-value">S/ <?php echo e(number_format($amount ?? 0, 2)); ?></span>
                            </div>
                        </div>

                        <div class="request-actions">
                            <a href="<?php echo e(route('mentorias.show', $session)); ?>" class="btn btn-request-neutral">Ver detalles</a>
                            <?php if($session->estado === 'pendiente'): ?>
                                <form method="POST" action="<?php echo e(route('mentor.mentorias.accept', $session)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-request-accept">Aceptar</button>
                                </form>
                                <form method="POST" action="<?php echo e(route('mentor.mentorias.reject', $session)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-request-reject">Rechazar</button>
                                </form>
                            <?php endif; ?>
                            <?php if(in_array($session->estado, ['pagada', 'confirmada'])): ?>
                                <form method="POST" action="<?php echo e(route('mentor.mentorias.completar', $session)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-request-accept" style="background:linear-gradient(135deg,#0ea5e9,#6366f1);">Completar sesi�n</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="request-card" style="text-align:center;color:#6b7280;">
                        Aún no tienes solicitudes de estudiantes.
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dateEl = document.getElementById('mentorMentoriasCurrentDate');
        if (dateEl) {
            const formatter = new Intl.DateTimeFormat('es-PE', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            const formatted = formatter.format(new Date());
            dateEl.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);
        }

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filter = this.dataset.filter;
                document.querySelectorAll('.mentoria-card').forEach(card => {
                    if (filter === 'todas') {
                        card.style.display = 'block';
                    } else if (filter === 'virtual' || filter === 'presencial') {
                        card.style.display = card.dataset.modalidad === filter ? 'block' : 'none';
                    } else {
                        card.style.display = card.dataset.estado === filter ? 'block' : 'none';
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/dashboard/mentor/mentorships.blade.php ENDPATH**/ ?>
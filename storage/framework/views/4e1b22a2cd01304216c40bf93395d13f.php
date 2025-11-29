

<?php
    $statusClasses = [
        'pendiente' => 'bg-amber-100 text-amber-700',
        'aceptada' => 'bg-blue-100 text-blue-700',
        'confirmada' => 'bg-blue-100 text-blue-700',
        'rechazada' => 'bg-rose-100 text-rose-700',
        'pagada' => 'bg-emerald-100 text-emerald-700',
        'completada' => 'bg-green-100 text-green-700',
        'cancelada' => 'bg-slate-200 text-slate-600',
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
?>

<?php $__env->startSection('mentor-title', 'Mis mentorías'); ?>
<?php $__env->startSection('mentor-subtitle', 'Define tus sesiones y tarifas personalizadas'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(108,71,255,0.08);
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .stat-card .stat-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #6b7280;
        font-weight: 600;
    }
    .stat-card .stat-value {
        font-size: 2.2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 32px;
    }
    .filter-btn {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        background: #fff;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .filter-btn.active {
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
    }
    .cards-grid, .requests-grid {
        display: grid;
        gap: 24px;
    }
    .item-card {
        background: #fff;
        border-radius: 24px;
        padding: 28px;
        border: 1px solid rgba(108,71,255,0.08);
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        gap: 24px;
    }
    .card-title {
        margin: 0 0 8px;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1f2937;
    }
    .card-price {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .info-grid {
        padding: 20px;
        border-radius: 16px;
        border: 1px solid rgba(108,71,255,0.1);
        background: linear-gradient(135deg, rgba(108,71,255,0.02), rgba(139,92,246,0.03));
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        margin-bottom: 24px;
    }
    .info-item .info-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #6b7280;
        font-weight: 600;
    }
    .info-item .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
    }
    .actions-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .actions-row .btn {
        padding: 10px 20px;
        border-radius: 12px;
        border-width: 2px;
        border-style: solid;
        font-weight: 600;
        font-size: .9rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        color: #fff;
        border-color: transparent;
    }
    .btn-secondary {
        border-color: rgba(108,71,255,0.2);
        color: #6c47ff;
        background: transparent;
    }
    .btn-outline {
        border-color: #d1d5db;
        color: #6b7280;
        background: transparent;
    }
    .request-section {
        margin-top: 48px;
    }
    .request-card {
        position: relative;
        overflow: hidden;
        border-radius: 32px;
        padding: 32px;
        border: 1px solid rgba(108,71,255,0.1);
        box-shadow: 0 20px 60px rgba(15,23,42,0.08);
        background: #fff;
    }
    .request-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(108,71,255,0.08), rgba(139,92,246,0.12));
        opacity: 0;
        transition: opacity .3s ease;
    }
    .request-card:hover::before {
        opacity: 1;
    }
    .request-card > * {
        position: relative;
        z-index: 1;
    }
    .request-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 20px;
    }
    .request-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 4px 0;
    }
    .request-student {
        color: #6b7280;
        font-weight: 600;
        font-size: .95rem;
    }
    .request-date {
        color: #94a3b8;
        font-size: .85rem;
    }
    .request-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
        padding: 20px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(108,71,255,0.02), rgba(139,92,246,0.04));
        border: 1px solid rgba(108,71,255,0.08);
        margin-bottom: 20px;
    }
    .request-meta-item .label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
        font-weight: 600;
    }
    .request-meta-item .value {
        margin-top: 4px;
        font-weight: 600;
        color: #1f2937;
    }
    .request-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .request-actions .btn {
        border-radius: 14px;
        font-weight: 600;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .request-status {
        border-radius: 999px;
        font-size: .85rem;
        padding: .45rem 1.2rem;
        font-weight: 700;
    }
    .btn-request-neutral {
        background: rgba(108,71,255,0.12);
        color: #6c47ff;
    }
    .btn-request-accept {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff;
        box-shadow: 0 12px 25px rgba(16,185,129,0.3);
    }
    .btn-request-reject {
        background: rgba(248,113,113,0.15);
        color: #dc2626;
        border: 1px solid rgba(248,113,113,0.4);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('mentor-actions'); ?>
    <a href="<?php echo e(route('mentorias.create')); ?>" class="btn btn-primary" style="border-radius: 999px; padding: 12px 32px;">
        ✨ Crear mentoría
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mentor-content'); ?>
    <div class="space-y-8">
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Borradores</span>
                <span class="stat-value"><?php echo e($listMentorias->where('estado', 'borrador')->count()); ?></span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Publicadas</span>
                <span class="stat-value"><?php echo e($listMentorias->where('estado', 'publicada')->count()); ?></span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Ingresos del mes</span>
                <span class="stat-value">S/ <?php echo e(number_format($ingresosDelMes ?? 0, 0)); ?></span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Valoración promedio</span>
                <span class="stat-value"><?php echo e(number_format($valoracionPromedio ?? 0, 1)); ?></span>
            </div>
        </div>

        <div class="filter-bar">
            <button class="filter-btn active" data-filter="todas">Todas</button>
            <button class="filter-btn" data-filter="borrador">Borradores</button>
            <button class="filter-btn" data-filter="publicada">Publicadas</button>
            <button class="filter-btn" data-filter="virtual">Virtual</button>
            <button class="filter-btn" data-filter="presencial">Presencial</button>
        </div>

        <div class="cards-grid">
            <?php $__empty_1 = true; $__currentLoopData = $listMentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="item-card" data-estado="<?php echo e($mentoria->estado); ?>" data-modalidad="<?php echo e($mentoria->modalidad); ?>">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title"><?php echo e($mentoria->titulo); ?></h3>
                            <p class="card-subtitle">
                                <?php echo e(ucfirst($mentoria->categoria)); ?> · <?php echo e(ucfirst($mentoria->modalidad)); ?>

                            </p>
                        </div>
                        <div class="card-price">S/ <?php echo e(number_format($mentoria->precio, 2)); ?></div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Duración</span>
                            <span class="info-value"><?php echo e($mentoria->duracion_minutos ?? $mentoria->duracion); ?> minutos</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Modalidad</span>
                            <span class="info-value"><?php echo e(ucfirst($mentoria->modalidad)); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <?php echo e($mentoria->estado === 'publicada' ? 'Sesiones' : 'Creada'); ?>

                            </span>
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
                            <span class="badge <?php echo e($mentoria->estado === 'publicada' ? 'badge-success' : ($mentoria->estado === 'borrador' ? 'badge-warning' : 'badge-slate')); ?>">
                                <?php echo e(ucfirst($mentoria->estado)); ?>

                            </span>
                        </div>
                    </div>

                    <div class="actions-row">
                        <a href="<?php echo e(route('mentorias.edit', $mentoria)); ?>" class="btn btn-primary">✏️ Editar</a>

                        <?php if($mentoria->estado === 'borrador'): ?>
                            <form action="<?php echo e(route('mentor.mentorias.publicar', $mentoria)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-secondary">🚀 Publicar</button>
                            </form>
                        <?php endif; ?>

                        <a href="<?php echo e(route('mentorias.show', $mentoria)); ?>" class="btn btn-outline" target="_blank">👁️ <?php echo e($mentoria->estado === 'borrador' ? 'Vista previa' : 'Ver público'); ?></a>

                        <?php if($mentoria->estado === 'borrador'): ?>
                            <form action="<?php echo e(route('mentor.mentorias.destroy', $mentoria)); ?>" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline">🗑️ Eliminar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="item-card">
                    <div class="text-center">
                        <p class="text-4xl mb-2">📚</p>
                        <h3 class="text-lg font-semibold text-secondary">No tienes mentorías creadas</h3>
                        <p class="text-sm text-slate-500 mb-4">Comienza a compartir tu experiencia creando mentorías personalizadas.</p>
                        <a href="<?php echo e(route('mentorias.create')); ?>" class="btn btn-primary">Crear mi primera mentoría</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="request-section">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Solicitudes recibidas</h3>
                    <p class="text-sm text-slate-500">?ltimas solicitudes de tus mentor?as publicadas</p>
                </div>
                <span class="text-sm text-slate-500"><?php echo e($stats['total'] ?? 0); ?> registro(s)</span>
            </div>

            <div class="requests-grid">
                <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $badge = $statusClasses[$session->estado] ?? 'bg-slate-100 text-slate-600';
                        $scheduleDate = $session->fecha_programada ?? $session->fecha_mentoria;
                        $scheduleTime = $session->hora_programada ?? optional($session->fecha_mentoria)?->format('H:i');
                        $amount = $session->monto ?? $session->precio;
                    ?>
                    <article class="request-card">
                        <div class="request-header">
                            <div>
                                <p class="request-student">Estudiante: <?php echo e($session->estudiante->name ?? 'No asignado'); ?></p>
                                <h4 class="request-title"><?php echo e($session->titulo); ?></h4>
                                <p class="request-date">Solicitada <?php echo e(optional($session->fecha_solicitud)->format('d/m/Y H:i') ?? 'sin fecha'); ?></p>
                            </div>
                            <span class="badge request-status <?php echo e($badge); ?>"><?php echo e(ucfirst($session->estado)); ?></span>
                        </div>

                        <div class="request-meta">
                            <div class="request-meta-item">
                                <span class="label">Fecha</span>
                                <span class="value"><?php echo e(optional($scheduleDate)->format('d/m/Y') ?? 'Por definir'); ?></span>
                            </div>
                            <div class="request-meta-item">
                                <span class="label">Hora</span>
                                <span class="value"><?php echo e($scheduleTime ?? 'Por definir'); ?></span>
                            </div>
                            <div class="request-meta-item">
                                <span class="label">Modalidad</span>
                                <span class="value capitalize"><?php echo e($session->modalidad); ?></span>
                            </div>
                            <div class="request-meta-item">
                                <span class="label">Monto</span>
                                <span class="value">S/ <?php echo e(number_format($amount ?? 0, 2)); ?></span>
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
                                    <button type="submit" class="btn btn-request-accept" style="background:linear-gradient(135deg,#0ea5e9,#6366f1);box-shadow:0 12px 25px rgba(99,102,241,.25);">Completar sesi?n</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="request-card text-center text-sm text-slate-500">
                        A?n no tienes solicitudes de estudiantes.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            document.querySelectorAll('.item-card').forEach(card => {
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
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/dashboard/mentor/mentorships.blade.php ENDPATH**/ ?>
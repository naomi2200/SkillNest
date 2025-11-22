<?php $__env->startSection('mentor-title', 'Mis mentorias'); ?>
<?php $__env->startSection('mentor-subtitle', 'Solicitudes recientes y sesiones confirmadas'); ?>

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
?>

<?php $__env->startSection('mentor-content'); ?>
    <div class="space-y-6">
        <?php if(session('status')): ?>
            <div class="rounded-2xl border border-success/20 bg-success/5 px-4 py-3 text-sm text-success">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <p class="text-sm text-slate-500">Solicitudes pendientes</p>
                <p class="mt-2 text-2xl font-semibold text-secondary"><?php echo e($stats['pending'] ?? 0); ?></p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <p class="text-sm text-slate-500">Aceptadas</p>
                <p class="mt-2 text-2xl font-semibold text-secondary"><?php echo e($stats['accepted'] ?? 0); ?></p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <p class="text-sm text-slate-500">Activas / proximas</p>
                <p class="mt-2 text-2xl font-semibold text-secondary"><?php echo e($stats['active'] ?? 0); ?></p>
            </div>
        </div>

        <div class="card space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Mis mentorías creadas</h3>
                    <p class="text-sm text-slate-500">Gestiona tus borradores o sesiones publicadas sin estudiante.</p>
                </div>
                <span class="text-sm text-slate-500"><?php echo e($createdMentorias->count()); ?> registradas</span>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $createdMentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h4 class="text-lg font-semibold text-secondary"><?php echo e($mentoria->titulo); ?></h4>
                            <p class="text-sm text-slate-500">
                                <?php echo e($mentoria->especialidad ?? 'Especialidad no definida'); ?> · <?php echo e(ucfirst($mentoria->estado)); ?>

                            </p>
                        </div>
                        <span class="text-sm font-semibold text-secondary">
                            S/ <?php echo e(number_format($mentoria->precio ?? 0, 2)); ?>

                        </span>
                    </div>

                    <dl class="mt-4 grid gap-4 text-sm text-slate-500 sm:grid-cols-4">
                        <div>
                            <dt class="font-medium text-slate-600">Duración</dt>
                            <dd><?php echo e($mentoria->duracion_minutos); ?> min</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Modalidad</dt>
                            <dd class="capitalize"><?php echo e($mentoria->modalidad); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Creada</dt>
                            <dd><?php echo e(optional($mentoria->created_at)->format('d/m/Y')); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Estado</dt>
                            <dd class="font-semibold"><?php echo e(ucfirst($mentoria->estado)); ?></dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="<?php echo e(route('mentor.mentorias.edit', $mentoria)); ?>" class="btn-secondary">
                            Editar
                        </a>
                        <form action="<?php echo e(route('mentor.mentorias.destroy', $mentoria)); ?>" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-secondary bg-rose-50 text-rose-600 border-rose-200">
                                Eliminar
                            </button>
                        </form>
                        <?php if($mentoria->estado === 'borrador'): ?>
                            <form action="<?php echo e(route('mentor.mentorias.publicar', $mentoria)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary">
                                    Publicar
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no has creado mentorías.
                </p>
            <?php endif; ?>
        </div>

        <div class="card space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Mis mentorías publicadas</h3>
                    <p class="text-sm text-slate-500">Actualmente visibles para los estudiantes.</p>
                </div>
                <span class="text-sm text-slate-500"><?php echo e($publishedMentorias->count()); ?> publicadas</span>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $publishedMentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h4 class="text-lg font-semibold text-secondary"><?php echo e($mentoria->titulo); ?></h4>
                            <p class="text-sm text-slate-500">
                                <?php echo e($mentoria->especialidad ?? 'Especialidad no definida'); ?> · Publicada <?php echo e(optional($mentoria->updated_at)->format('d/m/Y')); ?>

                            </p>
                        </div>
                        <span class="text-sm font-semibold text-secondary">
                            S/ <?php echo e(number_format($mentoria->precio ?? 0, 2)); ?>

                        </span>
                    </div>

                    <dl class="mt-4 grid gap-4 text-sm text-slate-500 sm:grid-cols-3">
                        <div>
                            <dt class="font-medium text-slate-600">Duración</dt>
                            <dd><?php echo e($mentoria->duracion_minutos); ?> min</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Modalidad</dt>
                            <dd class="capitalize"><?php echo e($mentoria->modalidad); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Estado</dt>
                            <dd class="text-success font-semibold">Publicada</dd>
                        </div>
                    </dl>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="<?php echo e(route('mentor.mentorias.edit', $mentoria)); ?>" class="btn-secondary">
                            Editar
                        </a>
                        <form action="<?php echo e(route('mentor.mentorias.destroy', $mentoria)); ?>" method="POST" onsubmit="return confirm('¿Eliminar esta mentoría?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-secondary bg-rose-50 text-rose-600 border-rose-200">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    No tienes mentorías publicadas.
                </p>
            <?php endif; ?>
        </div>

        <div class="card space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold text-secondary">Solicitudes recibidas</h3>
                    <p class="text-sm text-slate-500">Acepta o rechaza cada solicitud y consulta los detalles de la sesión.</p>
                </div>
                <span class="text-sm text-slate-500"><?php echo e($stats['total'] ?? 0); ?> registro(s)</span>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $badge = $statusClasses[$session->estado] ?? 'bg-slate-100 text-slate-600';
                    $scheduleDate = $session->fecha_programada ?? $session->fecha_mentoria;
                    $scheduleTime = $session->hora_programada ?? optional($session->fecha_mentoria)?->format('H:i');
                    $amount = $session->monto ?? $session->precio;
                    $canJoinNow = $session->session_link && in_array($session->estado, ['pagada', 'confirmada', 'completada']);
                ?>
                <article class="rounded-2xl border border-slate-100 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Estudiante: <?php echo e($session->estudiante->name ?? 'No asignado'); ?></p>
                            <h4 class="text-lg font-semibold text-secondary"><?php echo e($session->titulo); ?></h4>
                            <p class="text-xs text-slate-500">Especialidad: <?php echo e($session->especialidad ?? 'Generalista'); ?></p>
                            <p class="text-sm text-slate-500">
                                Solicitada <?php echo e(optional($session->fecha_solicitud)->format('d/m/Y H:i') ?? 'sin fecha'); ?>

                            </p>
                        </div>
                        <span class="badge <?php echo e($badge); ?>"><?php echo e(ucfirst($session->estado)); ?></span>
                    </div>

                    <dl class="mt-4 grid gap-4 text-sm text-slate-500 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <dt class="font-medium text-slate-600">Fecha</dt>
                            <dd><?php echo e(optional($scheduleDate)->format('d/m/Y') ?? 'Por definir'); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Hora</dt>
                            <dd><?php echo e($scheduleTime ?? 'Por definir'); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Modalidad</dt>
                            <dd class="capitalize"><?php echo e($session->modalidad); ?></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-600">Monto</dt>
                            <dd>S/ <?php echo e(number_format($amount ?? 0, 2)); ?></dd>
                        </div>
                    </dl>

                    <?php if($canJoinNow && $session->jitsi_room): ?>
                        <?php
                            $displayName = urlencode(auth()->user()?->name ?? 'Mentor');
                            $subject = urlencode('SkillNest - Sesión de Mentoría');
                            $joinUrl = "{$session->jitsi_room}#userInfo.displayName={$displayName}&config.requireDisplayName=true&subject={$subject}";
                        ?>
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="<?php echo e($joinUrl); ?>" target="_blank" class="btn-primary">
                                Unirse a la sesión
                            </a>
                            
                        </div>
                    <?php endif; ?>

                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <a href="<?php echo e(route('mentorias.show', $session)); ?>" class="btn-secondary">
                            Ver detalles
                        </a>

                        <?php if($session->estado === 'pendiente'): ?>
                            <form method="POST" action="<?php echo e(route('mentor.mentorias.accept', $session)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary bg-emerald-500 hover:bg-emerald-600 border-emerald-500 text-white">
                                    ACEPTAR
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('mentor.mentorias.reject', $session)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-secondary bg-rose-500 hover:bg-rose-600 text-white border-rose-500">
                                    RECHAZAR
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if(in_array($session->estado, ['pagada', 'confirmada'])): ?>
                            <form method="POST" action="<?php echo e(route('mentor.mentorias.completar', $session)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary bg-secondary border-secondary text-white">
                                    Completar sesión
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                    Aún no tienes solicitudes de estudiantes.
                </p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/dashboard/mentor/mentorships.blade.php ENDPATH**/ ?>
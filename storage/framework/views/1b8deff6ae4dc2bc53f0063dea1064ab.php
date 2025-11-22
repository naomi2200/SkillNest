<?php $__env->startSection('dashboard-title', 'Mis mentorias'); ?>

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

<?php $__env->startSection('dashboard-content'); ?>
    
    <div class="rounded-3xl border border-slate-100 bg-white/80 p-6 shadow-lg shadow-primary/5 transition hover:shadow-xl animate-fadeIn">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Sesiones</p>
                <h2 class="text-2xl font-semibold text-secondary">Sesiones agendadas</h2>
                <p class="text-sm text-slate-500">Revisa tus próximas mentorías y sus detalles.</p>
            </div>
            <a href="<?php echo e(route('mentor-market.index')); ?>"
               class="btn-secondary rounded-full px-5 py-2 shadow-card transition hover:scale-[1.01]">
                Explorar mentores
            </a>
        </div>

        
        <div class="mt-6 overflow-x-auto rounded-3xl border border-slate-100 bg-slate-50/70 p-4">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="text-left text-xs uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="px-4 py-3">Tema</th>
                    <th class="px-4 py-3">Mentor</th>
                    <th class="px-4 py-3">Especialidad</th>
                    <th class="px-4 py-3">Fecha programada</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $mentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        // Calcula estilos y fechas de la mentoría actual
                        $badge = $statusClasses[$mentoria->estado] ?? 'bg-slate-100 text-slate-600';
                        $scheduleDate = $mentoria->fecha_programada ?? $mentoria->fecha_mentoria;
                    ?>
                    <tr class="text-slate-600 transition hover:bg-white hover:shadow-md">
                        <td class="px-4 py-4 font-semibold text-secondary"><?php echo e($mentoria->titulo); ?></td>
                        <td class="px-4 py-4"><?php echo e($mentoria->mentor->name ?? 'Por asignar'); ?></td>
                        <td class="px-4 py-4"><?php echo e($mentoria->especialidad ?? 'General'); ?></td>
                        <td class="px-4 py-4"><?php echo e(optional($scheduleDate)->format('d/m/Y H:i') ?? 'Por definir'); ?></td>
                        <td class="px-4 py-4">
                            <span class="badge <?php echo e($badge); ?> capitalize"><?php echo e($mentoria->estado); ?></span>
                        </td>
                        <?php
                            // Prepara datos para unirse a Jitsi cuando el estado lo permita
                            $displayName = urlencode(auth()->user()?->name ?? 'Invitado');
                            $subject = urlencode('SkillNest - Sesión de Mentoría');
                            $joinUrl = $mentoria->jitsi_room
                                ? "{$mentoria->jitsi_room}#userInfo.displayName={$displayName}&config.requireDisplayName=true&subject={$subject}"
                                : null;
                        ?>
                        <td class="px-4 py-4 space-y-2 text-center">
                            
                            <?php if($mentoria->estado === 'rechazada'): ?>
                                <span class="inline-flex items-center justify-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-500 shadow-sm">
                                    Tu solicitud fue rechazada por el mentor.
                                </span>
                            <?php else: ?>
                                
                                <?php if($mentoria->estado === 'aceptada' && $mentoria->payment_status === 'pending'): ?>
                                    <a href="<?php echo e(route('mentorias.payment.show', $mentoria->id)); ?>"
                                       class="btn-primary inline-flex w-full items-center justify-center rounded-full px-4 py-2 text-xs shadow-card transition hover:shadow-lg">
                                        Pagar mentoría
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($mentoria->estado === 'pagada' && $joinUrl): ?>
                                    <a href="<?php echo e($joinUrl); ?>"
                                       target="_blank"
                                       class="btn-success inline-flex w-full items-center justify-center rounded-full px-4 py-2 text-xs shadow-card transition hover:shadow-lg">
                                        Unirse a la sesión
                                    </a>
                                <?php endif; ?>

                                
                                <?php if($mentoria->estado === 'completada'): ?>
                                    <span class="text-green-600 font-semibold text-xs">Sesión completada</span>
                                <?php endif; ?>

                                
                                <?php if($mentoria->estado === 'pendiente'): ?>
                                    <span class="text-xs text-slate-400">Esperando la aprobación del mentor</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                            No tienes mentorías registradas todavía.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/dashboard/student/mentorias.blade.php ENDPATH**/ ?>
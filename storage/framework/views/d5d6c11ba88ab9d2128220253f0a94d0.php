

<?php $__env->startSection('admin-title', 'Curso: ' . $course->title); ?>
<?php $__env->startSection('admin-subtitle', 'Revision y acciones administrativas del curso'); ?>

<?php $__env->startSection('admin-actions'); ?>
    <a href="<?php echo e(route('admin.courses.index')); ?>"
       class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-primary hover:text-primary">
        Volver al listado
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="space-y-8">
        <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Detalle del curso</p>
                    <h1 class="text-3xl font-bold text-secondary"><?php echo e($course->title); ?></h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Mentor: <span class="font-semibold text-secondary"><?php echo e($course->mentor->name ?? 'Sin asignar'); ?></span>
                    </p>
                    <p class="text-sm text-slate-500">
                        Creado el <?php echo e($course->created_at?->format('d/m/Y H:i') ?? 'Sin fecha'); ?>

                    </p>
                </div>
                <span class="rounded-full px-4 py-1 text-sm font-semibold capitalize
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'bg-amber-100 text-amber-700' => $course->status === 'pendiente',
                        'bg-emerald-100 text-emerald-700' => $course->status === 'aprobado',
                        'bg-rose-100 text-rose-600' => $course->status === 'rechazado',
                    ]); ?>"">
                    <?php echo e($course->status); ?>

                </span>
            </div>
            <?php if($course->rejection_reason): ?>
                <div class="mt-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-600">
                    <p class="font-semibold">Motivo de rechazo:</p>
                    <p><?php echo e($course->rejection_reason); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card space-y-3">
                <h2 class="text-lg font-semibold text-secondary">Información general</h2>
                <p><span class="font-semibold text-secondary">Descripción:</span> <?php echo e($course->description); ?></p>
                <p><span class="font-semibold text-secondary">Categoría:</span> <?php echo e($course->category); ?></p>
                <p><span class="font-semibold text-secondary">Nivel:</span> <?php echo e($course->level); ?></p>
                <p><span class="font-semibold text-secondary">Duración:</span> <?php echo e($course->duration); ?> horas</p>
                <p><span class="font-semibold text-secondary">Precio:</span> S/ <?php echo e(number_format($course->price, 2)); ?></p>
                <?php if($course->objectives): ?>
                    <p><span class="font-semibold text-secondary">Objetivos:</span> <?php echo e($course->objectives); ?></p>
                <?php endif; ?>
                <?php if($course->requirements): ?>
                    <p><span class="font-semibold text-secondary">Requisitos:</span> <?php echo e($course->requirements); ?></p>
                <?php endif; ?>
            </div>
            <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card space-y-4">
                <h2 class="text-lg font-semibold text-secondary">Acciones</h2>
                <div class="space-y-3">
                    <?php if($course->status === 'pendiente'): ?>
                        <form action="<?php echo e(route('admin.courses.approve', $course->id)); ?>" method="POST" class="flex flex-col gap-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="rounded-full bg-emerald-100 px-6 py-2 text-sm font-semibold text-emerald-700 shadow-card hover:bg-emerald-200">
                                Aprobar curso
                            </button>
                        </form>
                        <form action="<?php echo e(route('admin.courses.reject', $course->id)); ?>" method="POST" class="flex flex-col gap-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <label for="rejection_reason" class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                                Motivo del rechazo
                            </label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                                      class="rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none"
                                      placeholder="Describe los cambios solicitados..."></textarea>
                            <button type="submit"
                                    class="rounded-full bg-rose-100 px-6 py-2 text-sm font-semibold text-rose-600 shadow-card hover:bg-rose-200">
                                Rechazar curso
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if(in_array($course->status, ['rechazado', 'aprobado'], true)): ?>
                        <form action="<?php echo e(route('admin.courses.reset', $course->id)); ?>" method="POST" class="flex flex-col gap-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="rounded-full bg-amber-100 px-6 py-2 text-sm font-semibold text-amber-700 shadow-card hover:bg-amber-200">
                                Volver a revisión
                            </button>
                        </form>
                    <?php endif; ?>
                    <form action="<?php echo e(route('admin.courses.destroy', $course->id)); ?>" method="POST" class="pt-2">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="rounded-full bg-slate-100 px-6 py-2 text-sm font-semibold text-slate-600 shadow-card hover:bg-slate-200"
                                onclick="return confirm('¿Estás seguro de eliminar este curso?');">
                            Eliminar curso
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="rounded-[32px] border border-slate-200 bg-white/95 p-6 shadow-card">
            <h2 class="text-lg font-semibold text-secondary">Módulos y lecciones</h2>
            <div class="mt-4 space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Módulo <?php echo e($module->position); ?></p>
                                <h3 class="text-base font-semibold text-secondary"><?php echo e($module->title); ?></h3>
                            </div>
                            <span class="text-xs text-slate-500"><?php echo e($module->lessons->count()); ?> lecciones</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600"><?php echo e($module->description ?? 'Sin descripción.'); ?></p>
                        <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-slate-500">
                            <?php $__empty_2 = true; $__currentLoopData = $module->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <li>
                                    <?php echo e($lesson->title); ?>

                                    <span class="text-xs uppercase text-slate-400">(<?php echo e($lesson->type); ?>)</span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <li class="italic text-slate-400">Sin lecciones registradas.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="rounded-2xl border border-dashed border-slate-200 p-4 text-center text-sm text-slate-500">
                        No se han configurado módulos para este curso.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/admin/courses/show.blade.php ENDPATH**/ ?>
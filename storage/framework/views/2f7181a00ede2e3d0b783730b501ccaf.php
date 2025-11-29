<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-4xl space-y-8">
        <div class="rounded-3xl bg-white p-8 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-400">Mentoría</p>
                    <h1 class="text-4xl font-bold text-secondary"><?php echo e($mentoria->titulo); ?></h1>
                    <p class="mt-2 text-sm text-slate-500"><?php echo e($mentoria->mentor->name ?? 'Mentor por asignar'); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm uppercase tracking-wide text-slate-400">Tarifa</p>
                    <p class="text-3xl font-bold text-primary">S/ <?php echo e(number_format($mentoria->precio, 2)); ?></p>
                </div>
            </div>
            <p class="mt-6 text-slate-600"><?php echo e($mentoria->descripcion); ?></p>

            <div class="mt-8 flex flex-wrap gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('student.mentorias')); ?>" class="btn-primary">Agendar sesión</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-primary">Ingresa para agendar</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $mentoria)): ?>
                    <a href="<?php echo e(route('mentorias.edit', $mentoria)); ?>" class="btn-secondary">Editar mentoría</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="card">
                <h2 class="text-lg font-semibold text-secondary">Modalidad</h2>
                <p class="mt-4 text-sm text-slate-500"><?php echo e(ucfirst($mentoria->modalidad)); ?></p>
            </div>
            <div class="card">
                <h2 class="text-lg font-semibold text-secondary">Duración</h2>
                <p class="mt-4 text-sm text-slate-500"><?php echo e($mentoria->duracion_minutos); ?> minutos</p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/mentorias/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <div class="space-y-8">
        <?php if (! empty(trim($__env->yieldContent('dashboard-hero')))): ?>
            <?php echo $__env->yieldContent('dashboard-hero'); ?>
        <?php else: ?>
            <header class="rounded-[40px] border border-slate-100 bg-gradient-to-r from-white via-slate-50 to-white px-6 py-6 text-secondary shadow-card">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div class="space-y-2">
                        <p class="text-xs uppercase tracking-[0.5em] text-slate-400">Hola, <?php echo e(auth()->user()->name); ?></p>
                        <h1 class="text-3xl font-semibold"><?php echo $__env->yieldContent('dashboard-title', 'Panel'); ?></h1>
                        <p class="text-sm text-slate-500"><?php echo $__env->yieldContent('dashboard-subtitle', 'Explora y gestiona todo tu ecosistema SkillNest'); ?></p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <?php echo $__env->yieldContent('dashboard-actions'); ?>
                    </div>
                </div>
            </header>
        <?php endif; ?>

        <?php if (! empty(trim($__env->yieldContent('dashboard-widgets')))): ?>
            <section class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
                <?php echo $__env->yieldContent('dashboard-widgets'); ?>
            </section>
        <?php endif; ?>

        <section class="space-y-6">
            <?php echo $__env->yieldContent('dashboard-content'); ?>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>
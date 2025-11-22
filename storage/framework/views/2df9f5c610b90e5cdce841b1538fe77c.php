<?php $__env->startSection('content'); ?>
    <div class="space-y-8">
        <header class="rounded-[32px] border border-slate-100 bg-white/90 px-8 py-6 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Panel mentor</p>
                    <h1 class="text-3xl font-semibold text-secondary"><?php echo $__env->yieldContent('mentor-title', 'Mi panel de mentor'); ?></h1>
                    <p class="text-sm text-slate-500"><?php echo $__env->yieldContent('mentor-subtitle', 'Gestiona tus cursos y mentorías'); ?></p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <?php echo $__env->yieldContent('mentor-actions'); ?>
                </div>
            </div>
        </header>

        <main class="space-y-6">
            <?php echo $__env->yieldContent('mentor-content'); ?>
        </main>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/layouts/mentor.blade.php ENDPATH**/ ?>
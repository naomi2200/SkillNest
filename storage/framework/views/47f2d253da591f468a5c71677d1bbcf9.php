<?php $__env->startSection('content'); ?>
    <div class="flex min-h-[80vh] items-center justify-center py-12">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-secondary"><?php echo $__env->yieldContent('title'); ?></h1>
                <p class="mt-2 text-sm text-slate-500"><?php echo $__env->yieldContent('subtitle'); ?></p>
            </div>

            <div class="card">
                <?php echo $__env->yieldContent('form'); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/layouts/guest.blade.php ENDPATH**/ ?>
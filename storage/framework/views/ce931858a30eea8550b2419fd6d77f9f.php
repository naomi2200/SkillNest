<?php $user = auth()->user(); ?>

<?php $__env->startSection('dashboard-hero'); ?>
    <header class="dashboard-hero">
        <span class="dashboard-hero__badge">Hola, <?php echo e($user->name); ?></span>
        <div class="dashboard-hero__content">
            <div class="dashboard-hero__text">
                <h1>Panel general</h1>
                <p>Explora y gestiona tus cursos, mentorías y preferencias dentro del ecosistema SkillNest.</p>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-content'); ?>
    <div class="dashboard-card">
        <p class="text-sm text-slate-500">Este espacio está disponible para estudiantes y mentores. Selecciona una opción del menú lateral para continuar.</p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/dashboard/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <?php
        $isRegister = request()->routeIs('register');
        $icon = $isRegister ? '✨' : '🔐';
        $ctaTitle = $isRegister ? '¿Ya tienes cuenta?' : '¿Aún no tienes cuenta?';
        $ctaText = $isRegister
            ? 'Ingresa para continuar con tus cursos, retomar mentorías y gestionar tus notificaciones.'
            : 'Únete a la comunidad SkillNest para acceder a cursos, mentorías y certificaciones verificables.';
        $ctaUrl = $isRegister ? route('login') : route('register');
        $ctaLabel = $isRegister ? 'Inicia sesión' : 'Crear cuenta';
        $ctaList = $isRegister
            ? ['Accede a tus cursos guardados', 'Retoma el progreso de tus mentorías', 'Administra tus notificaciones']
            : ['Cursos en vivo y on demand', 'Mentorías personalizadas', 'Certificados verificables'];
    ?>

    <div class="auth-page">
        <div class="auth-shell">
            <div class="auth-wrapper">
                <section class="auth-card auth-card-main">
                    <div class="auth-header">
                        <div class="auth-icon"><?php echo e($icon); ?></div>
                        <h1 class="auth-title"><?php echo $__env->yieldContent('title'); ?></h1>
                        <p class="auth-subtitle"><?php echo $__env->yieldContent('subtitle'); ?></p>
                    </div>

                    <?php if(session('status')): ?>
                        <div class="auth-alert">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <span><?php echo e(session('status')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="auth-alert error">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="7" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            <span><?php echo e(__('Por favor revisa la información ingresada.')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('form'); ?>
                </section>

                <section class="auth-card auth-card-side">
                    <h3><?php echo e($ctaTitle); ?></h3>
                    <p><?php echo e($ctaText); ?></p>

                    <ul class="auth-side-list">
                        <?php $__currentLoopData = $ctaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($item); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <a href="<?php echo e($ctaUrl); ?>" class="auth-side-button"><?php echo e($ctaLabel); ?></a>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/layouts/guest.blade.php ENDPATH**/ ?>
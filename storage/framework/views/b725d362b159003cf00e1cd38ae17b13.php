<header class="sticky top-0 z-50 border-b bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-20 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 text-2xl font-bold text-secondary">
            <svg class="h-9 w-9 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 7h16M4 12h10m-6 5h12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            SkillNest
        </a>

        <nav class="hidden flex-1 justify-center gap-8 text-sm font-semibold text-slate-500 lg:flex">
            <a href="<?php echo e(route('cursos.index')); ?>" class="<?php echo e(request()->routeIs('cursos.*') ? 'text-secondary' : 'hover:text-secondary'); ?>">Cursos</a>
            <a href="<?php echo e(route('mentor-market.index')); ?>" class="<?php echo e(request()->routeIs('mentor-market.*') ? 'text-secondary' : 'hover:text-secondary'); ?>">Mentorías</a>
            <a href="<?php echo e(route('mentor.students')); ?>" class="<?php echo e(request()->routeIs('mentor.*') ? 'text-secondary' : 'hover:text-secondary'); ?>">Conviértete en Mentor</a>
        </nav>

        <?php
            $webUser = auth()->user();
            $adminUser = auth('admin')->user();
        ?>

        <div class="flex items-center gap-3">
            <?php if($webUser): ?>
                <?php
                    $panelRoute = $webUser->isMentor()
                        ? route('mentor.courses')
                        : ($webUser->isStudent() ? route('student.dashboard') : route('dashboard'));
                ?>
                <a href="<?php echo e($panelRoute); ?>" class="btn-secondary rounded-full px-5">Panel</a>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn-gradient">Salir</button>
                </form>
            <?php elseif($adminUser): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-secondary rounded-full px-5">Panel admin</a>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn-gradient">Salir</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-secondary rounded-full px-5">Iniciar sesión</a>
                <a href="<?php echo e(route('register')); ?>" class="btn-gradient">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</header>




<?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/partials/header.blade.php ENDPATH**/ ?>
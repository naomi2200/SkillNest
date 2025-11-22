<?php $__env->startSection('title', 'Inicia sesión'); ?>
<?php $__env->startSection('subtitle', 'Accede con tu cuenta para continuar'); ?>

<?php $__env->startSection('form'); ?>
    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="text-sm font-medium text-slate-600" for="email">Correo</label>
            <input id="email" name="email" type="email" required autofocus
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div>
            <label class="text-sm font-medium text-slate-600" for="password">Contraseña</label>
            <input id="password" name="password" type="password" required
                   class="mt-1 w-full rounded-lg border-slate-200 text-slate-700 focus:border-primary focus:ring-primary" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2 text-slate-500">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
                Recordarme
            </label>
            <a href="<?php echo e(route('password.request')); ?>" class="font-medium text-primary hover:text-primary/80">
                ¿Olvidaste tu contraseña?
            </a>
        </div>

        <button class="btn-primary w-full">Ingresar</button>

        <p class="text-center text-sm text-slate-500">
            ¿Aún no tienes cuenta?
            <a href="<?php echo e(route('register')); ?>" class="font-semibold text-primary">Crear cuenta</a>
        </p>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/auth/login.blade.php ENDPATH**/ ?>
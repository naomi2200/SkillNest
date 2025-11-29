<?php $__env->startSection('title', 'Inicia sesi&oacute;n'); ?>
<?php $__env->startSection('subtitle', 'Accede con tu cuenta para continuar'); ?>

<?php $__env->startSection('form'); ?>
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <div class="auth-field">
            <label for="email">Correo electr&oacute;nico</label>
            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" autofocus required class="auth-input">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="auth-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="auth-field">
            <label for="password">Contrase&ntilde;a</label>
            <input id="password" name="password" type="password" required class="auth-input">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="auth-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="auth-options">
            <label class="auth-checkbox">
                <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <span>Recordarme</span>
            </label>
            <a href="<?php echo e(route('password.request')); ?>" class="auth-link">&iquest;Olvidaste tu contrase&ntilde;a?</a>
        </div>

        <button class="btn-submit" type="submit">Ingresar</button>

        <p class="text-sm" style="text-align: center; color: #6b7280; margin-top: 10px;">
            &iquest;A&uacute;n no tienes cuenta?
            <a href="<?php echo e(route('register')); ?>" class="auth-link">Crear cuenta</a>
        </p>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/auth/login.blade.php ENDPATH**/ ?>
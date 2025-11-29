<?php $__env->startSection('title', 'Crea tu cuenta'); ?>
<?php $__env->startSection('subtitle', '&Uacute;nete a SkillNest y comienza a aprender o ense&ntilde;ar'); ?>

<?php $__env->startSection('form'); ?>
    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>
        <div class="auth-field">
            <label for="name">Nombre completo</label>
            <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required class="auth-input">
            <?php $__errorArgs = ['name'];
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
            <label for="email">Correo electr&oacute;nico</label>
            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required class="auth-input">
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

        <div class="auth-field">
            <label for="password_confirmation">Confirma tu contrase&ntilde;a</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="auth-input">
        </div>

        <div class="auth-field">
            <label for="role">Soy</label>
            <select id="role" name="role" class="auth-input">
                <option value="student" <?php echo e(old('role') === 'student' ? 'selected' : ''); ?>>Estudiante</option>
                <option value="mentor" <?php echo e(old('role') === 'mentor' ? 'selected' : ''); ?>>Mentor</option>
            </select>
        </div>

        <button class="btn-submit" type="submit">Crear cuenta</button>

        <p class="text-sm" style="text-align: center; color: #6b7280; margin-top: 10px;">
            &iquest;Ya tienes cuenta?
            <a href="<?php echo e(route('login')); ?>" class="auth-link">Inicia sesi&oacute;n</a>
        </p>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/auth/register.blade.php ENDPATH**/ ?>
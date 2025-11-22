<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? config('app.name', 'SkillNest')); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php ($viteManifest = public_path('build/manifest.json')); ?>
    <?php if(file_exists($viteManifest)): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <?php endif; ?>
    <style>
        :root {
            --color-primary: #6C47FF;
            --color-primary-hover: #8B5CF6;
            --color-background: #F6F6F6;
            --color-text: #333333;
            --color-success: #4CAF50;
            --color-danger: #FF5252;
            --radius-base: 8px;
            --shadow-card: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-background);
            color: var(--color-text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app-shell {
            min-height: 100vh;
            background: var(--color-background);
        }

        .app-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #FFFFFF;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .app-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .app-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 0;
        }

        .app-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            color: var(--color-primary);
        }

        .app-logo span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-base);
            background: var(--color-primary);
            color: #FFF;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 15px;
            font-weight: 500;
        }

        .main-nav a:hover {
            color: var(--color-primary);
        }

        .app-main {
            padding: 96px 0 48px;
        }

        .app-footer {
            background: #FFFFFF;
            border-top: 1px solid rgba(0,0,0,0.05);
            text-align: center;
            padding: 32px 0;
            font-size: 14px;
            color: rgba(51,51,51,0.7);
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 48px;
            padding: 0 32px;
            border-radius: var(--radius-base);
            font-size: 15px;
            font-weight: 600;
            transition: background 0.2s ease, border 0.2s ease, color 0.2s ease;
        }

        .btn-primary {
            background: var(--color-primary);
            border: none;
            color: #FFF;
            box-shadow: var(--shadow-card);
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
        }

        .btn-secondary {
            background: #FFF;
            border: 1px solid rgba(0,0,0,0.12);
            color: var(--color-text);
        }

        .btn-secondary:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .card {
            background: #FFF;
            border-radius: var(--radius-base);
            padding: 24px;
            box-shadow: var(--shadow-card);
        }

        .input {
            width: 100%;
            height: 44px;
            padding: 0 16px;
            border-radius: var(--radius-base);
            border: 1px solid rgba(0,0,0,0.12);
            background: #FFF;
            font-size: 15px;
            color: var(--color-text);
        }

        .input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(108,71,255,0.15);
        }

        .badge-success,
        .badge-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 12px;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius-base);
        }

        .badge-success {
            background: rgba(76,175,80,0.12);
            color: var(--color-success);
        }

        .badge-danger {
            background: rgba(255,82,82,0.12);
            color: var(--color-danger);
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="app-shell">
        <header class="app-header">
            <div class="app-container">
                <div class="app-nav">
                    <a class="app-logo" href="<?php echo e(url('/')); ?>">
                        <span>SN</span>
                        SkillNest
                    </a>
                    <nav class="main-nav">
                        <a href="<?php echo e(url('/cursos')); ?>">Cursos</a>
                        <a href="<?php echo e(url('/mentor-market')); ?>">Mentorías</a>
                        <a href="<?php echo e(url('/mentorias/create')); ?>">Conviértete en mentor</a>
                    </nav>
                    <div class="flex items-center gap-3">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn-secondary">Panel</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-primary">Salir</button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn-secondary">Ingresar</a>
                            <a href="<?php echo e(route('register')); ?>" class="btn-primary">Crear cuenta</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <main class="app-main">
            <div class="app-container">
                <?php echo $__env->renderWhen(View::exists('partials.notifications'), 'partials.notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        <footer class="app-footer">
            <div class="app-container">
                © <?php echo e(date('Y')); ?> SkillNest. Todos los derechos reservados.
            </div>
        </footer>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>
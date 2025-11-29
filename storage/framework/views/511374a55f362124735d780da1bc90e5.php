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
            --color-primary: #6c47ff;
            --color-primary-hover: #5a38e6;
            --color-background: #f7f6ff;
            --color-text: #1f2233;
            --color-success: #4CAF50;
            --color-danger: #FF5252;
            --radius-base: 12px;
            --shadow-card: 0 10px 40px rgba(0, 0, 0, 0.08);
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

        .navbar-modern {
            position: sticky;
            top: 0;
            z-index: 60;
            background: rgba(255,255,255,0.95);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            backdrop-filter: blur(12px);
        }

        .navbar-container,
        .app-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            padding: 18px 24px;
        }

        .navbar-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 22px;
            color: var(--color-primary);
        }

        .navbar-logo .logo-text {
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .logo-icon {
            font-size: 28px;
        }

        .navbar-links {
            display: flex;
            gap: 32px;
            flex: 1;
            justify-content: center;
        }

        .navbar-links a {
            font-weight: 600;
            color: #4b5563;
            font-size: 15px;
            position: relative;
            padding: 8px 0;
            transition: color 0.2s ease;
        }

        .navbar-links a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--color-primary), #8b5cf6);
            transition: width 0.3s ease;
            border-radius: 999px;
        }

        .navbar-links a:hover {
            color: var(--color-primary);
        }

        .navbar-links a:hover::after {
            width: 100%;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-nav-secondary,
        .btn-nav-primary {
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-nav-secondary {
            background: transparent;
            color: var(--color-primary);
        }

        .btn-nav-secondary:hover {
            background: rgba(108,71,255,0.08);
        }

        .btn-nav-primary {
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(108,71,255,0.3);
        }

        .btn-nav-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108,71,255,0.4);
        }

        .app-main {
            padding: 48px 0 64px;
        }

        .card {
            background: #fff;
            border-radius: var(--radius-base);
            padding: 24px;
            box-shadow: var(--shadow-card);
        }

        .auth-page {
            margin-top: -24px;
            margin-bottom: -32px;
            padding: 64px 0 96px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .auth-shell {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .auth-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: stretch;
        }

        .auth-card {
            background: #fff;
            border-radius: 32px;
            padding: 48px;
            box-shadow: 0 40px 120px rgba(12, 10, 37, 0.18);
            flex: 1 1 360px;
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--color-primary), #8b5cf6, #a855f7);
        }

        .auth-card-side {
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            box-shadow: 0 50px 140px rgba(108, 71, 255, 0.35);
        }

        .auth-card-side::before {
            display: none;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #fff;
            box-shadow: 0 25px 60px rgba(108, 71, 255, 0.35);
        }

        .auth-title {
            margin: 0;
            font-size: 2.2rem;
            font-weight: 800;
            color: #1f2937;
        }

        .auth-subtitle {
            margin-top: 12px;
            font-size: 1rem;
            color: #6b7280;
        }

        .auth-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(5,150,105,0.1));
            border: 1px solid rgba(16,185,129,0.25);
            color: #065f46;
            font-size: 0.9rem;
            margin-bottom: 24px;
        }

        .auth-alert.error {
            background: linear-gradient(135deg, rgba(248,113,113,0.18), rgba(239,68,68,0.14));
            border-color: rgba(239,68,68,0.4);
            color: #7f1d1d;
        }

        .auth-card-main form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .auth-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .auth-field label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
        }

        .auth-input,
        .auth-field select {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 1rem;
            background: #f9fafb;
            transition: all 0.3s ease;
        }

        .auth-input:focus,
        .auth-field select:focus {
            outline: none;
            border-color: var(--color-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(108,71,255,0.12);
        }

        .auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            font-size: 0.9rem;
        }

        .auth-checkbox {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #4b5563;
        }

        .auth-checkbox input {
            width: 18px;
            height: 18px;
            accent-color: var(--color-primary);
        }

        .auth-link {
            color: var(--color-primary);
            font-weight: 600;
        }

        .auth-link:hover {
            color: var(--color-primary-hover);
        }

        .auth-error {
            font-size: 0.85rem;
            color: #ef4444;
            margin: -4px 0 0;
        }

        .auth-card-side h3 {
            margin: 0 0 12px;
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
        }

        .auth-card-side p {
            color: rgba(255,255,255,0.85);
            line-height: 1.6;
            margin: 0 0 20px;
        }

        .auth-side-list {
            list-style: none;
            padding: 0;
            margin: 0 0 28px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .auth-side-list li {
            position: relative;
            padding-left: 32px;
            font-weight: 600;
            color: rgba(255,255,255,0.95);
        }

        .auth-side-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 1px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .auth-side-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 30px;
            border-radius: 14px;
            background: #fff;
            color: var(--color-primary);
            font-weight: 700;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        .auth-side-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 60px rgba(0,0,0,0.25);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 15px 40px rgba(108,71,255,0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 60px rgba(108,71,255,0.35);
        }

        @media (max-width: 1024px) {
            .auth-card {
                padding: 40px 32px;
            }
        }

        @media (max-width: 768px) {
            .auth-page {
                padding: 48px 0 72px;
            }

            .auth-card {
                padding: 32px 24px;
            }

            .auth-wrapper {
                gap: 24px;
            }

            .auth-icon {
                width: 64px;
                height: 64px;
                font-size: 32px;
            }
        }

        @media (max-width: 1024px) {
            .navbar-links {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .navbar-actions {
                display: none;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="app-shell">
        <header class="navbar-modern">
            <div class="navbar-container">
                <a class="navbar-logo" href="<?php echo e(url('/')); ?>">
                    <span class="logo-icon">&#127891;</span>
                    <span class="logo-text">SkillNest</span>
                </a>
                <nav class="navbar-links">
                    <a href="<?php echo e(url('/cursos')); ?>">Cursos</a>
                    <a href="<?php echo e(route('mentor-market.index')); ?>">Mentor&iacute;as</a>
                    <a href="<?php echo e(url('/mentorias/create')); ?>">Convi&eacute;rtete en mentor</a>
                </nav>
                <div class="navbar-actions">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn-nav-secondary">Panel</a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-nav-primary" style="background: linear-gradient(135deg,#ef4444,#f97316); box-shadow: 0 4px 15px rgba(239,68,68,0.3);">Salir</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-nav-secondary">Ingresar</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-nav-primary">Crear cuenta</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main class="app-main">
            <div class="app-container">
                <?php echo $__env->renderWhen(View::exists('partials.notifications'), 'partials.notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        <?php if ($__env->exists('partials.footer')) echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>
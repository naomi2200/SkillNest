

<?php
    use Illuminate\Support\Facades\Route;

    $admin = auth()->user();
    $isCoursesRoute = request()->routeIs('admin.courses.*');
    $coursesView = $isCoursesRoute && request()->routeIs('admin.courses.index')
        ? request()->query('view', 'solicitudes')
        : 'tabla';
    $navLinks = [
        [
            'label' => 'Resumen',
            'icon' => 'fa-solid fa-chart-pie',
            'url' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'label' => 'Solicitudes',
            'icon' => 'fa-solid fa-folder-open',
            'url' => route('admin.courses.index', ['view' => 'solicitudes', 'status' => 'pendiente']),
            'active' => request()->routeIs('admin.courses.index') && $coursesView === 'solicitudes',
        ],
        [
            'label' => 'Cursos',
            'icon' => 'fa-solid fa-book',
            'url' => route('admin.courses.index', ['view' => 'tabla', 'status' => request()->query('status', 'pendiente')]),
            'active' => $isCoursesRoute && (!request()->routeIs('admin.courses.index') || $coursesView !== 'solicitudes'),
        ],
    ];
?>

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary: #7c3aed;
            --primary-2: #8b5cf6;
        }

        .app-main { padding: 0; background: transparent; }
        .app-container { max-width: none; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(124,58,237,0.08), transparent 35%),
                        radial-gradient(circle at 80% 0%, rgba(124,58,237,0.06), transparent 30%),
                        #f4f3ff;
            min-height: 100vh;
            color: #111827;
        }

        .admin-shell {
            display: flex;
            gap: 32px;
            min-height: calc(100vh - 96px);
            padding: clamp(24px, 3vw, 48px);
            align-items: stretch;
            width: 100%;
        }

        .admin-sidebar {
            position: sticky;
            top: clamp(96px, 12vh, 128px);
            align-self: flex-start;
            width: 260px;
            border-radius: 32px;
            background: linear-gradient(180deg, #ede9fe 0%, #ddd6fe 100%);
            border: 1px solid rgba(124,58,237,0.15);
            box-shadow: 0 20px 60px rgba(124,58,237,0.18);
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 64px);
            overflow-y: auto;
        }
        .admin-brand h2 {
            font-size: 26px;
            font-weight: 900;
            margin: 6px 0 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .admin-brand p {
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #a1a1aa;
        }
        .admin-nav {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 600;
            color: #3f3f46;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .admin-nav-icon {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: rgba(124,58,237,0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 16px;
            transition: all 0.2s ease;
        }
        .admin-nav-link:hover {
            background: rgba(124,58,237,0.12);
            color: var(--primary);
        }
        .admin-nav-link:hover .admin-nav-icon {
            background: rgba(124,58,237,0.2);
        }
        .admin-nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            box-shadow: 0 10px 25px rgba(124,58,237,0.25);
        }
        .admin-nav-link.active .admin-nav-icon {
            background: rgba(255,255,255,0.25);
            color: #fff;
        }

        .admin-main {
            flex: 1;
            border-radius: 32px;
            background: #fff;
            border: 1px solid rgba(124,58,237,0.12);
            box-shadow: 0 30px 60px rgba(124,58,237,0.12);
            padding: 40px;
            backdrop-filter: blur(12px);
            min-height: calc(100vh - 96px);
            display: flex;
            flex-direction: column;
        }
        .admin-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(15,23,42,0.08);
            margin-bottom: 32px;
        }
        .admin-header h1 { font-size: 32px; font-weight: 900; color: #1f2937; }
        .admin-header p { font-size: 14px; color: #6b7280; }
        .admin-actions { display: flex; gap: 12px; flex-wrap: wrap; }

        .admin-content { display: flex; flex-direction: column; gap: 24px; }
        .admin-content > * { width: 100%; }

        @media (max-width: 1200px) {
            .admin-shell { flex-direction: column; }
            .admin-sidebar { width: 100%; position: relative; top: 0; max-height: none; }
            .admin-main { min-height: auto; }
        }
        @media (max-width: 640px) {
            .admin-shell { padding: 20px; }
            .admin-main { padding: 28px 20px; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <p>Admin panel</p>
                <h2>SkillNest</h2>
            </div>
            <nav class="admin-nav">
                <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($link['url']); ?>" class="admin-nav-link <?php echo e($link['active'] ? 'active' : ''); ?>">
                        <span class="admin-nav-icon" aria-hidden="true">
                            <i class="<?php echo e($link['icon']); ?>"></i>
                        </span>
                        <span><?php echo e($link['label']); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
            <div style="margin-top:auto; font-size:12px; color:#6b7280;">
                <p style="font-size:11px; letter-spacing:0.25em; text-transform:uppercase;">Sesión</p>
                <p style="font-weight:700; color:#111827;"><?php echo e($admin->name ?? 'Administrador'); ?></p>
                <p><?php echo e($admin->email ?? 'admin@skillnest.com'); ?></p>
            </div>
        </aside>

        <div class="admin-main">
            <div class="admin-header">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Panel administrador</p>
                    <h1><?php echo $__env->yieldContent('admin-title', 'Panel administrativo'); ?></h1>
                    <p><?php echo $__env->yieldContent('admin-subtitle', 'Monitorea la actividad global'); ?></p>
                </div>
                <div class="admin-actions">
                    <?php echo $__env->yieldContent('admin-actions'); ?>
                </div>
            </div>

            <div class="admin-content">
                <?php echo $__env->yieldContent('admin-content'); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/layouts/admin.blade.php ENDPATH**/ ?>
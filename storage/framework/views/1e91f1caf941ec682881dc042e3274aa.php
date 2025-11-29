<?php
    use Illuminate\Support\Facades\Route;

    $user = auth()->user();
    $dashboardNav = [];

    if ($user?->isAdmin()) {
        $dashboardNav = [
            [
                'label' => 'Resumen',
                'icon' => '📊',
                'route' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
            ],
            [
                'label' => 'Solicitudes',
                'icon' => '🗂️',
                'route' => route('admin.courses.index', ['status' => 'pendiente', 'view' => 'solicitudes']),
                'active' => request()->routeIs('admin.courses.index') && request('view', 'solicitudes') === 'solicitudes',
            ],
            [
                'label' => 'Cursos',
                'icon' => '📚',
                'route' => route('admin.courses.index', ['status' => 'aprobado', 'view' => 'tabla']),
                'active' => request()->routeIs('admin.courses.index') && request('view') === 'tabla',
            ],
            [
                'label' => 'Configuración',
                'icon' => '⚙️',
                'route' => Route::has('profile.edit') ? route('profile.edit') : '#',
                'active' => request()->routeIs('profile.*'),
            ],
        ];
    } elseif ($user?->isMentor()) {
        $dashboardNav = [
            ['label' => 'Estudiantes', 'icon' => '👥', 'route' => route('mentor.students'), 'active' => request()->routeIs('mentor.students')],
            ['label' => 'Cursos', 'icon' => '📘', 'route' => route('mentor.courses'), 'active' => request()->routeIs('mentor.courses')],
            ['label' => 'Mentorías', 'icon' => '🤝', 'route' => route('mentor.mentorias.index'), 'active' => request()->routeIs('mentor.mentorias.*')],
            ['label' => 'Perfil', 'icon' => '👤', 'route' => route('mentor.profile'), 'active' => request()->routeIs('mentor.profile')],
        ];
    } elseif ($user?->isStudent()) {
        $dashboardNav = [
            ['label' => 'Resumen', 'icon' => '📊', 'route' => route('student.dashboard'), 'active' => request()->routeIs('student.dashboard')],
            ['label' => 'Mis cursos', 'icon' => '📚', 'route' => route('student.courses'), 'active' => request()->routeIs('student.courses')],
            ['label' => 'Mis mentorías', 'icon' => '🎯', 'route' => route('student.mentorias'), 'active' => request()->routeIs('student.mentorias')],
            ['label' => 'Perfil', 'icon' => '👤', 'route' => route('student.profile'), 'active' => request()->routeIs('student.profile')],
        ];
    } else {
        $dashboardNav = [
            ['label' => 'Resumen', 'icon' => '📊', 'route' => Route::has('dashboard') ? route('dashboard') : '#', 'active' => request()->routeIs('dashboard')],
            ['label' => 'Cursos', 'icon' => '📚', 'route' => Route::has('cursos.index') ? route('cursos.index') : '#', 'active' => request()->routeIs('cursos.*')],
            ['label' => 'Mentorías', 'icon' => '🤝', 'route' => Route::has('mentor.courses') ? route('mentor.courses') : '#', 'active' => str_starts_with(request()->route()?->getName(), 'mentor.')],
            ['label' => 'Configuración', 'icon' => '⚙️', 'route' => Route::has('profile.edit') ? route('profile.edit') : '#', 'active' => request()->routeIs('profile.*')],
        ];
    }
?>

<?php $__env->startPush('styles'); ?>
    <style>
        .dashboard-layout {
            position: relative;
            min-height: calc(100vh - 96px);
            background: linear-gradient(135deg, #f5f7ff 0%, #fef9f4 100%);
            border-radius: 48px 48px 0 0;
            padding: clamp(24px, 4vw, 48px);
        }
        .dashboard-layout::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(108,71,255,0.12) 0%, transparent 55%),
                radial-gradient(circle at 80% 80%, rgba(14,165,233,0.12) 0%, transparent 55%),
                radial-gradient(circle at 40% 20%, rgba(248,113,113,0.12) 0%, transparent 50%);
            border-radius: inherit;
            pointer-events: none;
        }
        .dashboard-shell {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 32px;
        }
        .dashboard-sidebar {
            width: 260px;
            background: rgba(255,255,255,0.95);
            border-radius: 32px;
            border: 1px solid rgba(226,232,240,0.8);
            padding: 28px 20px;
            box-shadow: 0 20px 45px rgba(15,23,42,0.08);
            position: sticky;
            top: clamp(96px, 12vh, 140px);
            align-self: flex-start;
        }
        .dashboard-sidebar h2 {
            font-size: 24px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 4px;
        }
        .dashboard-sidebar p {
            font-size: 11px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #94a3b8;
        }
        .dashboard-nav {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .dashboard-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 18px;
            text-decoration: none;
            color: #475569;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .dashboard-nav a::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(108,71,255,0.12), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }
        .dashboard-nav a:hover::before {
            transform: translateX(100%);
        }
        .dashboard-nav a:hover {
            color: var(--color-primary);
            background: rgba(108,71,255,0.08);
            box-shadow: 0 6px 18px rgba(108,71,255,0.15);
        }
        .dashboard-nav a.active {
            background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
            color: #fff;
            box-shadow: 0 12px 30px rgba(108,71,255,0.3);
        }
        .dashboard-nav span:first-child {
            width: 24px;
            text-align: center;
        }
        .dashboard-main {
            flex: 1;
            background: rgba(255,255,255,0.97);
            border-radius: 36px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 30px 60px rgba(15,23,42,0.12);
            padding: clamp(24px, 3vw, 40px);
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .dashboard-hero {
            border-radius: 32px;
            padding: clamp(24px, 3vw, 36px);
            background: linear-gradient(120deg, rgba(108,71,255,0.14), rgba(14,165,233,0.12));
            border: 1px solid rgba(108,71,255,0.18);
            box-shadow: 0 25px 50px rgba(108,71,255,0.15);
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .dashboard-hero__badge {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.35em;
            color: #6366f1;
        }
        .dashboard-hero__content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .dashboard-hero__text h1 {
            font-size: clamp(2rem, 4vw, 2.6rem);
            font-weight: 800;
            margin: 0;
            color: #1f2937;
        }
        .dashboard-hero__text p {
            margin: 6px 0 0;
            color: #475569;
            max-width: 520px;
        }
        .dashboard-hero__meta {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 10px 18px;
            border-radius: 20px;
            background: rgba(108,71,255,0.08);
            border: 1px solid rgba(108,71,255,0.15);
        }
        .dashboard-hero__avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border: 3px solid #fff;
        }
        .dashboard-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .dashboard-widgets {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        .dashboard-content {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 26px;
            padding: 28px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 16px 35px rgba(15,23,42,0.08);
        }
        .dashboard-grid {
            display: grid;
            gap: 24px;
        }
        .dashboard-grid.two {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }
        .dashboard-grid.three {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }
        @media (max-width: 1024px) {
            .dashboard-shell {
                flex-direction: column;
            }
            .dashboard-sidebar {
                width: 100%;
                position: static;
            }
        }
        @media (max-width: 768px) {
            .dashboard-layout {
                padding: 20px 16px;
                border-radius: 24px;
            }
            .dashboard-hero__content {
                flex-direction: column;
                align-items: flex-start;
            }
            .dashboard-hero__meta {
                width: 100%;
                justify-content: space-between;
            }
            .dashboard-hero__actions {
                width: 100%;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-layout">
        <div class="dashboard-shell">
            <aside class="dashboard-sidebar">
                <h2>SkillNest</h2>
                <p>Dashboard</p>
                <nav class="dashboard-nav">
                    <?php $__currentLoopData = $dashboardNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($item['route']); ?>" class="<?php echo e($item['active'] ? 'active' : ''); ?>">
                            <span><?php echo e($item['icon']); ?></span>
                            <span><?php echo e($item['label']); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            </aside>
            <div class="dashboard-main">
                <?php if (! empty(trim($__env->yieldContent('dashboard-hero')))): ?>
                    <?php echo $__env->yieldContent('dashboard-hero'); ?>
                <?php else: ?>
                    <header class="dashboard-hero">
                        <span class="dashboard-hero__badge">Hola, <?php echo e(auth()->user()->name); ?></span>
                        <div class="dashboard-hero__content">
                            <div class="dashboard-hero__text">
                                <h1><?php echo $__env->yieldContent('dashboard-title', 'Panel'); ?></h1>
                                <p><?php echo $__env->yieldContent('dashboard-subtitle', 'Explora y gestiona todo tu ecosistema SkillNest'); ?></p>
                            </div>
                            <div class="dashboard-hero__meta">
                                <div>
                                    <p class="font-semibold text-slate-800"><?php echo e(auth()->user()->name ?? 'Usuario SkillNest'); ?></p>
                                    <p class="text-sm text-slate-500"><?php echo e(auth()->user()->email ?? 'user@skillnest.com'); ?></p>
                                </div>
                                <div class="dashboard-hero__avatar">
                                    <?php echo e(strtoupper(substr(auth()->user()->name ?? 'S', 0, 1))); ?>

                                </div>
                            </div>
                        </div>
                        <div class="dashboard-hero__actions">
                            <?php echo $__env->yieldContent('dashboard-actions'); ?>
                        </div>
                    </header>
                <?php endif; ?>

                <?php if (! empty(trim($__env->yieldContent('dashboard-widgets')))): ?>
                    <section class="dashboard-widgets">
                        <?php echo $__env->yieldContent('dashboard-widgets'); ?>
                    </section>
                <?php endif; ?>

                <section class="dashboard-content">
                    <?php echo $__env->yieldContent('dashboard-content'); ?>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>
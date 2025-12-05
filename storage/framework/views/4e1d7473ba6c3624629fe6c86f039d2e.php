<?php
    use Illuminate\Support\Facades\Route;

    $student = auth()->user();
    $navLinks = [
        [
            'label' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge-high',
            'url' => route('student.dashboard'),
            'active' => request()->routeIs('student.dashboard'),
        ],
        [
            'label' => 'Mis cursos',
            'icon' => 'fa-solid fa-book-open',
            'url' => route('student.courses'),
            'active' => request()->routeIs('student.courses'),
        ],
        [
            'label' => 'Mis mentorías',
            'icon' => 'fa-solid fa-chalkboard-user',
            'url' => route('student.mentorias'),
            'active' => request()->routeIs('student.mentorias'),
        ],
        [
            'label' => 'Mi perfil',
            'icon' => 'fa-solid fa-user',
            'url' => route('student.profile'),
            'active' => request()->routeIs('student.profile'),
        ],
    ];
?>

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary: #7c3aed;
            --primary-2: #8b5cf6;
            --primary-3: #6d28d9;
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

        .student-shell {
            display: flex;
            gap: 32px;
            min-height: calc(100vh - 96px);
            padding: clamp(24px, 3vw, 48px);
            align-items: stretch;
            width: 100%;
        }

        .student-sidebar {
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
        .student-brand h2 {
            font-size: 26px;
            font-weight: 900;
            margin: 6px 0 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .student-brand p {
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #a1a1aa;
        }
        .student-nav {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .student-nav-link {
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
        .student-nav-icon {
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
        .student-nav-link:hover {
            background: rgba(124,58,237,0.12);
            color: var(--primary);
        }
        .student-nav-link:hover .student-nav-icon {
            background: rgba(124,58,237,0.2);
        }
        .student-nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            box-shadow: 0 10px 25px rgba(124,58,237,0.25);
        }
        .student-nav-link.active .student-nav-icon {
            background: rgba(255,255,255,0.25);
            color: #fff;
        }

        .student-main {
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
        .student-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(15,23,42,0.08);
            margin-bottom: 32px;
        }
        .student-header h1 { font-size: 32px; font-weight: 900; color: #1f2937; }
        .student-header p { font-size: 14px; color: #6b7280; }
        .student-actions { display: flex; gap: 12px; flex-wrap: wrap; }

        .student-content { display: flex; flex-direction: column; gap: 24px; }
        .student-content > * { width: 100%; }

        /* Estadísticas y tarjetas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            align-items: start;
        }
        .stat-card {
            background: #fff;
            border-radius: 22px;
            padding: 24px;
            border: 1px solid rgba(124,58,237,0.12);
            box-shadow: 0 10px 30px rgba(124,58,237,0.12);
            transition: all 0.25s ease;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 18px 32px rgba(124,58,237,0.2); }
        .stat-label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.12em; color: #94a3b8; font-weight: 600; }
        .stat-value {
            font-size: 36px;
            font-weight: 900;
            margin-top: 8px;
            color: var(--primary);
        }
        .stat-description { font-size: 13px; color: #6b7280; margin-top: 8px; }

        .content-card { background: #fff; border-radius: 26px; padding: 28px; border: 1px solid rgba(226,232,240,0.8); box-shadow: 0 12px 30px rgba(124,58,237,0.08); }
        .content-card h2 { font-size: 20px; font-weight: 800; color: #1f2937; margin-bottom: 16px; }
        .empty-state { text-align: center; padding: 40px 20px; }
        .empty-icon { font-size: 56px; margin-bottom: 12px; }
        .empty-text { color: #6b7280; font-size: 14px; }

        @media (max-width: 1200px) {
            .student-shell { flex-direction: column; }
            .student-sidebar { width: 100%; position: relative; top: 0; max-height: none; }
            .student-main { min-height: auto; }
        }
        @media (max-width: 640px) {
            .student-shell { padding: 20px; }
            .student-main { padding: 28px 20px; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="student-shell">
        <aside class="student-sidebar">
            <div class="student-brand">
                <p>Student panel</p>
                <h2>SkillNest</h2>
            </div>
            <nav class="student-nav">
                <?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($link['url']); ?>" class="student-nav-link <?php echo e($link['active'] ? 'active' : ''); ?>">
                        <span class="student-nav-icon" aria-hidden="true">
                            <i class="<?php echo e($link['icon']); ?>"></i>
                        </span>
                        <span><?php echo e($link['label']); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
            <div style="margin-top:auto; font-size:12px; color:#6b7280;">
                <p style="font-size:11px; letter-spacing:0.25em; text-transform:uppercase;">Sesión</p>
                <p style="font-weight:700; color:#111827;"><?php echo e($student->name); ?></p>
                <p><?php echo e($student->email); ?></p>
            </div>
        </aside>

        <div class="student-main">
            <div class="student-header">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Panel estudiante</p>
                    <h1><?php echo $__env->yieldContent('student-title', 'Panel del estudiante'); ?></h1>
                    <p><?php echo $__env->yieldContent('student-subtitle', 'Revisa tus cursos y mentorías'); ?></p>
                </div>
                <div class="student-actions">
                    <?php echo $__env->yieldContent('student-actions'); ?>
                </div>
            </div>

            <div class="student-content">
                <?php if (! empty(trim($__env->yieldContent('student-widgets')))): ?>
                    <div class="stats-grid">
                        <?php echo $__env->yieldContent('student-widgets'); ?>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('student-content'); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/layouts/student.blade.php ENDPATH**/ ?>
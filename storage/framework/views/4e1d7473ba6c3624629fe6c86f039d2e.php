<?php $__env->startPush('styles'); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(130deg, #eef2ff 0%, #fdf4ff 45%, #e0e7ff 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 12% 30%, rgba(167,139,250,0.18) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(196,181,253,0.14) 0%, transparent 55%),
                radial-gradient(circle at 50% 10%, rgba(191,219,254,0.15) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* Layout principal - PANTALLA COMPLETA con márgenes mínimos */
        .student-shell {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 20px;
            min-height: 100vh;
            padding: 16px;
            align-items: stretch;
            width: 100%;
        }
        
        /* Sidebar LATERAL IZQUIERDO - Estilo similar al mentor */
        .student-sidebar {
            position: sticky;
            top: 16px;
            align-self: flex-start;
            width: 260px;
            flex-shrink: 0;
            border-radius: 28px;
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(226,232,240,0.7);
            box-shadow: 0 10px 40px rgba(79,70,229,0.08);
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 32px);
            overflow-y: auto;
        }
        
        .student-brand {
            margin-bottom: 24px;
        }
        .student-brand p {
            font-size: 10px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #a1a1aa;
            margin-bottom: 4px;
            font-weight: 500;
        }
        .student-brand h2 {
            font-size: 24px;
            font-weight: 900;
            margin: 0;
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Navegación - Dashboard NO morado sino gris como mentor */
        .student-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }
        .student-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            color: #4c4f6b;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .student-nav-link span:first-child {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        .student-nav-link:hover {
            background: rgba(108,71,255,0.06);
            color: #6c47ff;
        }
        /* Dashboard activo - NO morado, sino con fondo sutil */
        .student-nav-link.active {
            background: rgba(108,71,255,0.1);
            color: #6c47ff;
        }
        
        .student-info {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(226,232,240,0.5);
            font-size: 12px;
            color: #94a3b8;
        }
        .student-info p:first-child {
            font-size: 10px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 500;
        }
        .student-info p:nth-child(2) {
            font-weight: 700;
            color: #1f2937;
            font-size: 13px;
            margin-bottom: 2px;
        }
        .student-info p:nth-child(3) {
            color: #6b7280;
            font-size: 11px;
        }
        
        /* Contenido principal - Márgenes mínimos */
        .student-main {
            flex: 1;
            border-radius: 28px;
            background: rgba(255,255,255,0.96);
            border: 1px solid rgba(226,232,240,0.7);
            box-shadow: 0 15px 50px rgba(99,102,241,0.1);
            padding: 32px;
            backdrop-filter: blur(10px);
            min-height: calc(100vh - 32px);
            display: flex;
            flex-direction: column;
        }
        
        /* Header - Tipografía similar al mentor */
        .student-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(226,232,240,0.6);
            margin-bottom: 28px;
        }
        .student-header .header-label {
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 6px;
            font-weight: 500;
        }
        .student-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
            line-height: 1.2;
        }
        .student-header .header-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.5;
        }
        
        .student-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        /* Estilos del contenido de ejemplo */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }
        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }
        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 900;
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }
        .stat-description {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.4;
        }
        .content-card {
            background: #fff;
            border-radius: 22px;
            padding: 28px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .content-card h2 {
            font-size: 20px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 16px;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        .empty-icon {
            font-size: 56px;
            margin-bottom: 12px;
        }
        .empty-text {
            color: #6b7280;
            font-size: 14px;
        }
        
        @media (max-width: 1200px) {
            .student-shell {
                flex-direction: column;
                padding: 12px;
            }
            .student-sidebar {
                width: 100%;
                position: relative;
                top: 0;
                max-height: none;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php
    $studentUser = auth()->user();
?>

<?php $__env->startSection('content'); ?>
    <div class="student-shell">
        <!-- SIDEBAR LATERAL IZQUIERDO -->
        <aside class="student-sidebar">
            <div class="student-brand">
                <p>STUDENT PANEL</p>
                <h2>SkillNest</h2>
            </div>
            <nav class="student-nav">
                <a href="<?php echo e(route('student.dashboard')); ?>" class="student-nav-link <?php echo e(request()->routeIs('student.dashboard') ? 'active' : ''); ?>">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('student.courses')); ?>" class="student-nav-link <?php echo e(request()->routeIs('student.courses') ? 'active' : ''); ?>">
                    <span>📘</span>
                    <span>Mis cursos</span>
                </a>
                <a href="<?php echo e(route('student.mentorias')); ?>" class="student-nav-link <?php echo e(request()->routeIs('student.mentorias') ? 'active' : ''); ?>">
                    <span>👥</span>
                    <span>Mis mentorías</span>
                </a>
                <a href="<?php echo e(route('student.profile')); ?>" class="student-nav-link <?php echo e(request()->routeIs('student.profile') ? 'active' : ''); ?>">
                    <span>👤</span>
                    <span>Mi perfil</span>
                </a>
            </nav>
            <div class="student-info">
                <p>SESIÓN</p>
                <p><?php echo e($studentUser->name ?? 'Estudiante'); ?></p>
                <p><?php echo e($studentUser->email ?? ''); ?></p>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="student-main">
            <div class="student-header">
                <div>
                    <p class="header-label">Panel estudiante</p>
                    <h1><?php echo $__env->yieldContent('student-title'); ?></h1>
                    <p class="header-subtitle"><?php echo $__env->yieldContent('student-subtitle'); ?></p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <?php echo $__env->yieldContent('student-actions'); ?>
                </div>
            </div>

            <div class="student-content">
                <section class="stats-grid">
                    <?php echo $__env->yieldContent('student-widgets'); ?>
                </section>

                <section class="mt-6">
                    <?php echo $__env->yieldContent('student-content'); ?>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/layouts/student.blade.php ENDPATH**/ ?>
<?php
    use Illuminate\Support\Facades\Route;

    $user = auth()->user();
    
    // Definir la navegación basada en el rol del usuario
    if ($user?->isMentor()) {
        $dashboardNav = [
            [
                'label' => 'Dashboard',
                'icon' => 'fas fa-th-large',
                'route' => route('dashboard'),
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'label' => 'Estudiantes',
                'icon' => 'fas fa-users',
                'route' => '#',
                'active' => false,
            ],
            [
                'label' => 'Cursos',
                'icon' => 'fas fa-book',
                'route' => route('cursos.index'),
                'active' => request()->routeIs('cursos.*'),
            ],
            [
                'label' => 'Mentorías',
                'icon' => 'fas fa-calendar-alt',
                'route' => '#',
                'active' => false,
            ],
            [
                'label' => 'Perfil',
                'icon' => 'fas fa-user',
                'route' => Route::has('profile.edit') ? route('profile.edit') : '#',
                'active' => request()->routeIs('profile.*'),
            ],
        ];
    } elseif ($user?->isStudent()) {
        $dashboardNav = [
            [
                'label' => 'Dashboard',
                'icon' => 'fas fa-th-large',
                'route' => route('dashboard'),
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'label' => 'Mis Cursos',
                'icon' => 'fas fa-book',
                'route' => route('student.courses'),
                'active' => request()->routeIs('student.courses'),
            ],
            [
                'label' => 'Mis Mentorías',
                'icon' => 'fas fa-calendar-alt',
                'route' => route('student.mentorias'),
                'active' => request()->routeIs('student.mentorias'),
            ],
            [
                'label' => 'Perfil',
                'icon' => 'fas fa-user',
                'route' => route('student.profile'),
                'active' => request()->routeIs('student.profile'),
            ],
        ];
    } else {
        // Navegación por defecto
        $dashboardNav = [
            [
                'label' => 'Dashboard',
                'icon' => 'fas fa-th-large',
                'route' => Route::has('dashboard') ? route('dashboard') : '#',
                'active' => request()->routeIs('dashboard'),
            ],
            [
                'label' => 'Cursos',
                'icon' => 'fas fa-book',
                'route' => Route::has('cursos.index') ? route('cursos.index') : '#',
                'active' => request()->routeIs('cursos.*'),
            ],
            [
                'label' => 'Mentorías',
                'icon' => 'fas fa-calendar-alt',
                'route' => '#',
                'active' => false,
            ],
            [
                'label' => 'Perfil',
                'icon' => 'fas fa-user',
                'route' => Route::has('profile.edit') ? route('profile.edit') : '#',
                'active' => request()->routeIs('profile.*'),
            ],
        ];
    }
    
    // Información del usuario
    $userName = auth()->user()->name ?? 'Usuario';
    $userEmail = auth()->user()->email ?? 'usuario@email.com';
    $userInitial = strtoupper(substr($userName, 0, 1));
?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --color-primary: #7c3aed;
        --color-primary-light: #8b5cf6;
        --color-dark: #1e293b;
        --color-light: #f8fafc;
        --color-gray: #64748b;
        --sidebar-width: 280px;
    }

    /* Layout Principal */
    .dashboard-layout {
        display: flex;
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f3ff 0%, #f0e9ff 100%);
    }

    /* Sidebar - Inspirado en la imagen */
    .dashboard-sidebar {
        width: var(--sidebar-width);
        background: linear-gradient(180deg, #ffffff 0%, #f8f5ff 100%);
        border-right: 1px solid rgba(124, 58, 237, 0.1);
        padding: 0;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .sidebar-brand {
        padding: 30px;
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
    }

    .sidebar-brand h1 {
        font-size: 28px;
        font-weight: 900;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0 0 8px 0;
    }

    .sidebar-brand .tagline {
        font-size: 12px;
        color: var(--color-gray);
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .sidebar-section {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .section-label {
        font-size: 11px;
        color: var(--color-primary);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-label::before {
        content: '';
        width: 4px;
        height: 4px;
        background: var(--color-primary);
        border-radius: 50%;
    }

    .dashboard-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        color: var(--color-gray);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.2s ease;
        font-weight: 500;
        border: 1px solid transparent;
    }

    .nav-item i {
        width: 20px;
        text-align: center;
        font-size: 16px;
    }

    .nav-item:hover {
        background: rgba(124, 58, 237, 0.08);
        color: var(--color-primary);
        transform: translateX(5px);
        border-color: rgba(124, 58, 237, 0.2);
    }

    .nav-item.active {
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        color: white;
        box-shadow: 0 8px 24px rgba(124, 58, 237, 0.3);
        border-color: transparent;
    }

    .nav-item.active i {
        color: white;
    }

    /* Sección de Usuario */
    .user-section {
        padding: 30px;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.05), rgba(139, 92, 246, 0.05));
        border-top: 1px solid rgba(124, 58, 237, 0.1);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .user-details h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: var(--color-dark);
    }

    .user-details p {
        margin: 2px 0 0 0;
        font-size: 12px;
        color: var(--color-gray);
    }

    /* Contenido Principal */
    .dashboard-main {
        flex: 1;
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        background: transparent;
    }

    /* Header del Dashboard */
    .dashboard-header {
        background: white;
        border-radius: 0 0 24px 24px;
        padding: 30px 40px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.1);
        border: 1px solid rgba(124, 58, 237, 0.1);
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .header-left h1 {
        font-size: 32px;
        font-weight: 800;
        color: var(--color-dark);
        margin: 0 0 8px 0;
    }

    .header-left p {
        color: var(--color-gray);
        margin: 0;
        font-size: 15px;
        max-width: 600px;
    }

    .user-welcome {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(124, 58, 237, 0.08);
        padding: 12px 20px;
        border-radius: 50px;
        border: 1px solid rgba(124, 58, 237, 0.2);
    }

    .welcome-text {
        font-weight: 600;
        color: var(--color-primary);
    }

    /* Contenido del Dashboard */
    .dashboard-content {
        max-width: 1200px;
        margin: 0 auto 40px;
        padding: 0 40px;
    }

    /* Grid de Widgets */
    .widgets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .widget-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid rgba(124, 58, 237, 0.1);
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.08);
        transition: all 0.3s ease;
    }

    .widget-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(124, 58, 237, 0.15);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .dashboard-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .dashboard-sidebar.active {
            transform: translateX(0);
        }
        
        .dashboard-main {
            margin-left: 0;
        }
        
        .sidebar-toggle {
            display: block;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            font-size: 20px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 20px;
            border-radius: 0 0 16px 16px;
        }
        
        .header-top {
            flex-direction: column;
            gap: 16px;
        }
        
        .dashboard-content {
            padding: 0 20px;
        }
        
        .widgets-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .dashboard-header {
            padding: 16px;
        }
        
        .header-left h1 {
            font-size: 24px;
        }
        
        .user-welcome {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-layout">
    <!-- Botón para mostrar/ocultar sidebar en móviles -->
    <button class="sidebar-toggle" id="sidebarToggle" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-brand">
            <h1>SkillNest</h1>
            <div class="tagline">PLATAFORMA EDUCATIVA</div>
        </div>

        <div class="sidebar-section">
            <div class="section-label">MENTOR PANEL</div>
            <nav class="dashboard-nav">
                <?php $__currentLoopData = $dashboardNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($item['route']); ?>" 
                       class="nav-item <?php echo e($item['active'] ? 'active' : ''); ?>"
                       onclick="<?php echo e(request()->routeIs('dashboard') && $item['label'] == 'Dashboard' ? 'event.preventDefault();' : ''); ?>">
                        <i class="<?php echo e($item['icon']); ?>"></i>
                        <span><?php echo e($item['label']); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
        </div>

        <!-- Sección del Usuario -->
        <div class="user-section">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo e($userInitial); ?>

                </div>
                <div class="user-details">
                    <h4><?php echo e($userName); ?></h4>
                    <p><?php echo e($userEmail); ?></p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="dashboard-main">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-content">
                <div class="header-top">
                    <div class="header-left">
                        <h1><?php echo $__env->yieldContent('dashboard-title', 'Dashboard'); ?></h1>
                        <p><?php echo $__env->yieldContent('dashboard-subtitle', 'Bienvenido a tu panel de control'); ?></p>
                    </div>
                    <div class="user-welcome">
                        <span class="welcome-text">Hola, <?php echo e($userName); ?></span>
                        <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">
                            <?php echo e($userInitial); ?>

                        </div>
                    </div>
                </div>
                
                <?php if (! empty(trim($__env->yieldContent('dashboard-actions')))): ?>
                    <div class="dashboard-actions">
                        <?php echo $__env->yieldContent('dashboard-actions'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </header>

        <!-- Widgets (si existen) -->
        <?php if (! empty(trim($__env->yieldContent('dashboard-widgets')))): ?>
            <section class="dashboard-content">
                <div class="widgets-grid">
                    <?php echo $__env->yieldContent('dashboard-widgets'); ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Contenido Principal -->
        <section class="dashboard-content">
            <?php echo $__env->yieldContent('dashboard-content'); ?>
        </section>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const dashboardSidebar = document.getElementById('dashboardSidebar');
    
    if (sidebarToggle && dashboardSidebar) {
        // Mostrar/ocultar botón en móviles
        function checkScreenSize() {
            if (window.innerWidth <= 1024) {
                sidebarToggle.style.display = 'block';
            } else {
                sidebarToggle.style.display = 'none';
                dashboardSidebar.classList.remove('active');
            }
        }
        
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
        
        // Toggle sidebar
        sidebarToggle.addEventListener('click', function() {
            dashboardSidebar.classList.toggle('active');
        });
        
        // Cerrar sidebar al hacer clic fuera en móviles
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024 && 
                !dashboardSidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target)) {
                dashboardSidebar.classList.remove('active');
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>
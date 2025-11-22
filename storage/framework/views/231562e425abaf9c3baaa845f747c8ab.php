<?php $__env->startPush('styles'); ?>
<style>
    .home-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px 96px;
        display: flex;
        flex-direction: column;
        gap: 96px;
    }
    .home-hero-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
        gap: 56px;
        align-items: center;
    }
    .home-hero-card {
        padding: 48px;
        border-radius: 32px;
        background: linear-gradient(135deg, #ffffff, #f8f8ff);
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        gap: 28px;
    }
    .home-hero-title {
        font-size: clamp(2.8rem, 4vw, 4rem);
        line-height: 1.1;
        margin: 0;
    }
    .home-hero-title span {
        color: var(--color-primary);
    }
    .home-hero-form {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-radius: 999px;
        border: 1px solid rgba(0,0,0,0.06);
        background: #fff;
        box-shadow: var(--shadow-card);
        align-items: center;
    }
    .home-hero-form input {
        flex: 1;
        border: none;
        font-size: 16px;
        background: transparent;
    }
    .home-hero-form input:focus { outline: none; }
    .home-hero-form svg { flex-shrink: 0; }
    .home-hero-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
    }
    .home-hero-stat {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 18px;
        background: #fff;
        box-shadow: var(--shadow-card);
    }
    .home-hero-stat span {
        font-weight: 700;
        color: var(--color-primary);
        font-size: 1.3rem;
    }
    .home-hero-media {
        border-radius: 32px;
        overflow: hidden;
        height: 100%;
        min-height: 420px;
        box-shadow: 0 40px 90px rgba(108,71,255,0.25);
    }
    .home-hero-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .home-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 24px;
    }
    .home-section-title {
        margin: 0;
        font-size: 2.25rem;
        color: #1f2937;
    }
    .home-section-text {
        color: #6b7280;
        line-height: 1.6;
    }
    .home-category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }
    .home-category-card {
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .home-category-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card);
    }
    .home-category-card img {
        width: 60px;
        height: 60px;
        object-fit: contain;
    }
    .home-course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 28px;
    }
    .home-course-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        height: 100%;
        gap: 0;
    }
    .home-course-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
    .home-course-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
        height: 100%;
    }
    .home-course-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: #6b7280;
    }
    .home-mentor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }
    .home-mentor-card {
        text-align: center;
        border-radius: 24px;
        padding: 30px;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .home-mentor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid rgba(108,71,255,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 26px;
        font-weight: 700;
        color: var(--color-primary);
    }
    .home-cta {
        border-radius: 32px;
        padding: 56px;
        background: linear-gradient(120deg, var(--color-primary), var(--color-primary-hover));
        color: #fff;
        box-shadow: var(--shadow-card);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 36px;
    }
    .home-cta ul {
        padding-left: 18px;
        margin: 16px 0;
        color: rgba(255,255,255,0.85);
    }
    @media (max-width: 768px) {
        .home-hero-grid {
            grid-template-columns: 1fr;
        }
        .home-hero-card {
            padding: 32px;
        }
        .home-hero-form {
            flex-direction: column;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php
    $categories = [
        ['name' => 'Programacion', 'courses' => 234, 'icon' => 'https://cdn-icons-png.flaticon.com/512/1006/1006363.png'],
        ['name' => 'Diseno', 'courses' => 156, 'icon' => 'https://cdn-icons-png.flaticon.com/512/1829/1829583.png'],
        ['name' => 'Marketing', 'courses' => 98, 'icon' => 'https://cdn-icons-png.flaticon.com/512/2463/2463510.png'],
        ['name' => 'Negocios', 'courses' => 145, 'icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135755.png'],
        ['name' => 'Fotografia', 'courses' => 67, 'icon' => 'https://cdn-icons-png.flaticon.com/512/860/860786.png'],
        ['name' => 'Musica', 'courses' => 43, 'icon' => 'https://cdn-icons-png.flaticon.com/512/727/727245.png'],
    ];
    $courses = [
        ['title' => 'Laravel Avanzado: De Cero a Experto','mentor' => 'Carlos Gomez','category' => 'Programacion','price' => 149,'rating' => 4.8,'students' => 1234,'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80'],
        ['title' => 'Vue.js Completo: Frontend Moderno','mentor' => 'Maria Lopez','category' => 'Programacion','price' => 139,'rating' => 4.9,'students' => 987,'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80'],
        ['title' => 'Diseno UX/UI: Interfaces Increibles','mentor' => 'Ana Garcia','category' => 'Diseno','price' => 129,'rating' => 4.7,'students' => 856,'image' => 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=900&q=80'],
    ];
    $mentors = [
        ['name' => 'Carlos Gomez','title' => 'Senior Laravel Developer','rating' => 4.9,'sessions' => 125,'price' => 80,'available' => true],
        ['name' => 'Maria Lopez','title' => 'Frontend Expert','rating' => 4.8,'sessions' => 98,'price' => 70,'available' => true],
        ['name' => 'Ana Garcia','title' => 'UX/UI Designer','rating' => 5.0,'sessions' => 156,'price' => 90,'available' => false],
        ['name' => 'Jose Ramirez','title' => 'Marketing Strategist','rating' => 4.7,'sessions' => 89,'price' => 75,'available' => true],
    ];
?>

<?php $__env->startSection('content'); ?>
    <div class="home-wrapper">
        <section class="home-hero-grid">
            <div class="card home-hero-card">
                <p class="text-sm font-semibold uppercase tracking-[0.4em] text-slate-400">Plataforma educativa</p>
                <h1 class="home-hero-title">Aprende de expertos o comparte tu <span>conocimiento</span></h1>
                <p class="home-section-text">Accede a mas de 500 cursos y conecta con mentores profesionales para impulsar tu crecimiento.</p>
                <form action="<?php echo e(route('cursos.index')); ?>" method="GET" class="home-hero-form">
                    <svg width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="rgba(51,51,51,0.4)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" name="q" placeholder="¿Qué quieres aprender hoy?">
                    <button type="submit" class="btn-primary">Buscar</button>
                </form>
                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo e(route('cursos.index')); ?>" class="btn-primary">Ver cursos publicados</a>
                    <a href="<?php echo e(route('mentor-market.index')); ?>" class="btn-secondary">Ver mentorías</a>
                </div>
                <div class="home-hero-stats">
                    <div class="home-hero-stat">
                        <span>500+</span>
                        <p class="home-section-text text-sm">Cursos</p>
                    </div>
                    <div class="home-hero-stat">
                        <span>10K</span>
                        <p class="home-section-text text-sm">Estudiantes</p>
                    </div>
                    <div class="home-hero-stat">
                        <span>4.8/5</span>
                        <p class="home-section-text text-sm">Valoración</p>
                    </div>
                    <div class="home-hero-stat">
                        <span>95%</span>
                        <p class="home-section-text text-sm">Finalizados</p>
                    </div>
                </div>
            </div>
            <div class="home-hero-media">
                <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=900&q=80" alt="Mentores SkillNest">
            </div>
        </section>

        <section class="space-y-6">
            <div class="home-section-header">
                <div>
                    <p class="text-sm text-slate-500">Categorías destacadas</p>
                    <h2 class="home-section-title">Explora por categoría</h2>
                </div>
                <a href="<?php echo e(route('cursos.index')); ?>" class="btn-secondary">Ver todos</a>
            </div>
            <div class="home-category-grid">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card home-category-card">
                        <img src="<?php echo e($category['icon']); ?>" alt="<?php echo e($category['name']); ?>">
                        <h3 class="text-lg font-semibold text-secondary"><?php echo e($category['name']); ?></h3>
                        <p class="home-section-text text-sm"><?php echo e($category['courses']); ?> cursos</p>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        <section class="space-y-6">
            <div class="home-section-header">
                <div>
                    <p class="text-sm text-slate-500">Contenido curado</p>
                    <h2 class="home-section-title">Cursos más populares</h2>
                </div>
                <a href="<?php echo e(route('cursos.index')); ?>" class="btn-secondary">Ver todos</a>
            </div>
            <div class="home-course-grid">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card home-course-card">
                        <img src="<?php echo e($course['image']); ?>" alt="<?php echo e($course['title']); ?>">
                        <div class="home-course-content p-6">
                            <span class="btn-secondary px-3 py-1 inline-flex justify-center"><?php echo e($course['category']); ?></span>
                            <div>
                                <h3 class="text-xl font-semibold text-secondary"><?php echo e($course['title']); ?></h3>
                                <p class="home-section-text text-sm"><?php echo e($course['mentor']); ?></p>
                            </div>
                            <div class="home-course-meta">
                                <span>⭐ <?php echo e($course['rating']); ?></span>
                                <span>👥 <?php echo e(number_format($course['students'])); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-2xl font-bold text-secondary">S/ <?php echo e($course['price']); ?></p>
                                <a href="<?php echo e(route('cursos.index')); ?>" class="btn-primary">Ver más</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        <section class="space-y-6">
            <div class="home-section-header">
                <div>
                    <p class="text-sm text-slate-500">Mentorías destacadas</p>
                    <h2 class="home-section-title">Aprende de los mejores</h2>
                </div>
                <a href="<?php echo e(route('mentor-market.index')); ?>" class="btn-secondary">Ver todos</a>
            </div>
            <div class="home-mentor-grid">
                <?php $__currentLoopData = $mentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card home-mentor-card">
                        <div class="home-mentor-avatar"><?php echo e(substr($mentor['name'], 0, 1)); ?></div>
                        <h3 class="text-lg font-semibold text-secondary"><?php echo e($mentor['name']); ?></h3>
                        <p class="home-section-text text-sm"><?php echo e($mentor['title']); ?></p>
                        <div class="flex items-center justify-center gap-4 text-sm text-slate-500">
                            <span>⭐ <?php echo e($mentor['rating']); ?></span>
                            <span>👥 <?php echo e($mentor['sessions']); ?></span>
                        </div>
                        <p class="text-2xl font-bold text-secondary">S/ <?php echo e($mentor['price']); ?>/hora</p>
                        <a href="<?php echo e(route('mentor-market.index')); ?>" class="btn-primary">Ver perfil</a>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        <section class="home-cta">
            <div class="space-y-4">
                <h2 class="text-3xl font-bold">¿Quieres aprender?</h2>
                <ul>
                    <li>Accede a cursos en vivo y on demand.</li>
                    <li>Agenda mentorías personalizadas.</li>
                    <li>Obtén certificados verificables.</li>
                </ul>
                <a href="<?php echo e(route('cursos.index')); ?>" class="btn-secondary border-white text-white">Explorar cursos</a>
            </div>
            <div class="space-y-4">
                <h2 class="text-3xl font-bold">¿Quieres enseñar?</h2>
                <ul>
                    <li>Crea y vende tus propios cursos.</li>
                    <li>Ofrece mentorías 1 a 1.</li>
                    <li>Genera ingresos recurrentes.</li>
                </ul>
                <a href="<?php echo e(route('register')); ?>" class="btn-secondary border-white text-white">Comenzar ahora</a>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/home.blade.php ENDPATH**/ ?>
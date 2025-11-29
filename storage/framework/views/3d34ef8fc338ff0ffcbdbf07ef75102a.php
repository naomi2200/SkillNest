<?php $__env->startPush('styles'); ?>
<style>
    .home-page {
        display: flex;
        flex-direction: column;
        gap: 96px;
        padding-bottom: 120px;
    }

    .home-hero-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
        gap: 56px;
        align-items: center;
    }

    .home-hero-card {
        background: #fff;
        border-radius: 32px;
        padding: 48px;
        box-shadow: 0 30px 80px rgba(108, 71, 255, 0.15);
        display: flex;
        flex-direction: column;
        gap: 28px;
        position: relative;
        overflow: hidden;
    }

    .home-hero-card::after {
        content: "";
        position: absolute;
        inset: 12px 12px auto auto;
        width: 160px;
        height: 32px;
        border-radius: 999px;
        border: 2px solid rgba(108, 71, 255, 0.15);
    }

    .home-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 999px;
        background: rgba(108, 71, 255, 0.08);
        border: 1px solid rgba(108, 71, 255, 0.2);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #6c47ff;
    }

    .home-hero-title {
        font-size: clamp(3rem, 5vw, 4.25rem);
        margin: 0;
        line-height: 1.05;
        font-weight: 800;
        color: #1f2937;
    }

    .home-hero-title span {
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
    }

    .home-hero-title span::after {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        right: 0;
        height: 5px;
        border-radius: 4px;
        background: linear-gradient(90deg, #6c47ff, #8b5cf6);
        opacity: 0.35;
    }

    .home-hero-subtitle {
        font-size: 1.15rem;
        color: #6b7280;
        margin: 0;
        line-height: 1.7;
    }

    .home-hero-form {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 20px;
        border: 2px solid rgba(0, 0, 0, 0.05);
        background: #fefefe;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
    }

    .home-hero-form:focus-within {
        border-color: #6c47ff;
        box-shadow: 0 26px 70px rgba(108, 71, 255, 0.25);
        transform: translateY(-2px);
    }

    .home-hero-form input {
        border: none;
        flex: 1;
        padding: 12px 4px;
        font-size: 1rem;
        background: transparent;
        color: #1f2937;
    }

    .home-hero-form input:focus {
        outline: none;
    }

    .home-hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .home-btn-primary,
    .home-btn-secondary {
        border-radius: 14px;
        padding: 13px 30px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 1rem;
    }

    .home-btn-primary {
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        color: #fff;
        box-shadow: 0 15px 40px rgba(108, 71, 255, 0.35);
    }

    .home-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 45px rgba(108, 71, 255, 0.45);
    }

    .home-btn-secondary {
        background: transparent;
        color: #6c47ff;
        border: 2px solid rgba(108, 71, 255, 0.4);
    }

    .home-btn-secondary:hover {
        background: rgba(108, 71, 255, 0.08);
        border-color: transparent;
    }

    .home-hero-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .home-hero-stat {
        background: #fff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        text-align: center;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .home-hero-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 60px rgba(108, 71, 255, 0.15);
        border-color: rgba(108, 71, 255, 0.3);
    }

    .home-hero-stat span {
        display: block;
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .home-hero-stat p {
        margin: 4px 0 0;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .home-hero-media {
        border-radius: 32px;
        padding: 24px;
        background: linear-gradient(135deg, rgba(108, 71, 255, 0.15), rgba(139, 92, 246, 0.2));
        box-shadow: 0 40px 100px rgba(108, 71, 255, 0.25);
        min-height: 480px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .home-hero-media img {
        width: 100%;
        height: 100%;
        border-radius: 26px;
        object-fit: cover;
        box-shadow: 0 20px 80px rgba(0, 0, 0, 0.2);
        transition: transform 0.6s ease;
    }

    .home-hero-media:hover img {
        transform: scale(1.03) rotate(1deg);
    }

    .home-section {
        display: flex;
        flex-direction: column;
        gap: 36px;
    }

    .home-section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
    }

    .home-section-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 999px;
        background: rgba(108, 71, 255, 0.08);
        color: #6c47ff;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .home-section-title {
        margin: 0;
        font-size: 2.4rem;
        color: #1f2937;
        font-weight: 800;
    }

    .home-category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }

    .home-category-card {
        background: #fff;
        border-radius: 28px;
        padding: 32px 24px;
        text-align: center;
        border: 2px solid transparent;
        box-shadow: 0 20px 40px rgba(13, 10, 44, 0.05);
        transition: all 0.25s ease;
    }

    .home-category-card:hover {
        transform: translateY(-8px);
        border-color: rgba(108, 71, 255, 0.4);
        box-shadow: 0 35px 70px rgba(108, 71, 255, 0.12);
    }

    .home-category-icon {
        width: 72px;
        height: 72px;
        border-radius: 22px;
        background: rgba(108, 71, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        transition: transform 0.25s ease, background 0.25s ease;
    }

    .home-category-card:hover .home-category-icon {
        transform: scale(1.1) rotate(3deg);
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
    }

    .home-category-icon img {
        width: 38px;
        height: 38px;
    }

    .home-category-card h3 {
        margin: 0;
        font-size: 1.1rem;
        color: #111827;
    }

    .home-category-card p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .home-course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 28px;
    }

    .home-course-card {
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        border: 2px solid transparent;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 25px 60px rgba(13, 10, 44, 0.08);
    }

    .home-course-card:hover {
        transform: translateY(-10px);
        border-color: rgba(108, 71, 255, 0.4);
        box-shadow: 0 35px 90px rgba(108, 71, 255, 0.18);
    }

    .home-course-image {
        height: 220px;
        overflow: hidden;
    }

    .home-course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .home-course-card:hover .home-course-image img {
        transform: scale(1.08);
    }

    .home-course-content {
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        flex: 1;
    }

    .home-course-category {
        display: inline-flex;
        padding: 6px 14px;
        border-radius: 999px;
        background: rgba(108, 71, 255, 0.12);
        color: #6c47ff;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
    }

    .home-course-title {
        margin: 0;
        font-size: 1.25rem;
        color: #111827;
        line-height: 1.4;
    }

    .home-course-mentor {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .home-course-meta {
        display: flex;
        gap: 18px;
        font-size: 0.9rem;
        color: #6b7280;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding-top: 16px;
    }

    .home-course-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
    }

    .home-course-price {
        font-size: 1.9rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
    }

    .home-mentor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
    }

    .home-mentor-card {
        border-radius: 26px;
        padding: 32px 24px;
        border: 2px solid transparent;
        background: #fff;
        text-align: center;
        box-shadow: 0 25px 60px rgba(10, 8, 30, 0.08);
        display: flex;
        flex-direction: column;
        gap: 14px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .home-mentor-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6c47ff, #8b5cf6);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        transform-origin: left;
    }

    .home-mentor-card:hover {
        transform: translateY(-8px);
        border-color: rgba(108, 71, 255, 0.4);
        box-shadow: 0 35px 80px rgba(108, 71, 255, 0.18);
    }

    .home-mentor-card:hover::before {
        transform: scaleX(1);
    }

    .home-mentor-avatar {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6);
        color: #fff;
        font-size: 32px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        box-shadow: 0 20px 55px rgba(108, 71, 255, 0.3);
        transition: transform 0.3s ease;
    }

    .home-mentor-card:hover .home-mentor-avatar {
        transform: scale(1.08) rotate(3deg);
    }

    .home-mentor-stats {
        display: inline-flex;
        gap: 14px;
        background: rgba(108, 71, 255, 0.08);
        border-radius: 999px;
        padding: 8px 18px;
        font-size: 0.85rem;
        color: #433d7b;
        font-weight: 600;
    }

    .home-mentor-price {
        margin: 10px 0 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .home-cta {
        border-radius: 40px;
        padding: 70px 60px;
        background: linear-gradient(135deg, #6c47ff, #8b5cf6 50%, #a855f7);
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 40px 110px rgba(108, 71, 255, 0.35);
    }

    .home-cta::before,
    .home-cta::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
    }

    .home-cta::before {
        width: 520px;
        height: 520px;
        top: -40%;
        right: -10%;
    }

    .home-cta::after {
        width: 360px;
        height: 360px;
        bottom: -30%;
        left: -6%;
    }

    .home-cta-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 48px;
    }

    .home-cta-block h2 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 800;
    }

    .home-cta-block ul {
        list-style: none;
        padding: 0;
        margin: 28px 0;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .home-cta-block li {
        position: relative;
        padding-left: 34px;
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .home-cta-block li::before {
        content: "\2713";
        position: absolute;
        left: 0;
        top: 4px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .home-cta .home-btn-secondary {
        background: #fff;
        color: #6c47ff;
        border: none;
        box-shadow: 0 20px 55px rgba(0, 0, 0, 0.2);
    }

    .home-cta .home-btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 26px 64px rgba(0, 0, 0, 0.26);
        background: #f5f5ff;
    }

    @media (max-width: 1024px) {
        .home-hero-grid {
            grid-template-columns: 1fr;
        }

        .home-hero-media {
            order: -1;
        }

        .home-hero-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .home-hero-card {
            padding: 32px;
        }

        .home-hero-form {
            flex-direction: column;
            align-items: stretch;
        }

        .home-btn-primary,
        .home-btn-secondary {
            width: 100%;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php
    $categories = [
        ['name' => 'Programación', 'courses' => '234 cursos', 'icon' => 'https://cdn-icons-png.flaticon.com/512/1006/1006363.png'],
        ['name' => 'Diseño', 'courses' => '156 cursos', 'icon' => 'https://cdn-icons-png.flaticon.com/512/1829/1829583.png'],
        ['name' => 'Marketing', 'courses' => '98 cursos', 'icon' => 'https://cdn-icons-png.flaticon.com/512/2463/2463510.png'],
        ['name' => 'Negocios', 'courses' => '145 cursos', 'icon' => 'https://cdn-icons-png.flaticon.com/512/3135/3135755.png'],
        ['name' => 'Fotografía', 'courses' => '67 cursos', 'icon' => 'https://cdn-icons-png.flaticon.com/512/860/860786.png'],
        ['name' => 'Música', 'courses' => '43 cursos', 'icon' => 'https://cdn-icons-png.flaticon.com/512/727/727245.png'],
    ];

    $courses = [
        [
            'title' => 'Laravel Avanzado: De Cero a Experto',
            'category' => 'Programación',
            'mentor' => 'Carlos Gómez',
            'rating' => '4.8',
            'students' => '1,234',
            'price' => 'S/ 149',
            'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
        ],
        [
            'title' => 'Vue.js Completo: Frontend Moderno',
            'category' => 'Programación',
            'mentor' => 'María López',
            'rating' => '4.9',
            'students' => '987',
            'price' => 'S/ 139',
            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80',
        ],
        [
            'title' => 'Diseño UX/UI: Interfaces Increíbles',
            'category' => 'Diseño',
            'mentor' => 'Ana García',
            'rating' => '4.7',
            'students' => '856',
            'price' => 'S/ 129',
            'image' => 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=900&q=80',
        ],
    ];

    $mentors = [
        ['name' => 'Carlos Gómez', 'role' => 'Senior Laravel Developer', 'initial' => 'C', 'rating' => '4.9', 'sessions' => 125, 'price' => 'S/ 80/hora'],
        ['name' => 'María López', 'role' => 'Frontend Expert', 'initial' => 'M', 'rating' => '4.8', 'sessions' => 98, 'price' => 'S/ 70/hora'],
        ['name' => 'Ana García', 'role' => 'UX/UI Designer', 'initial' => 'A', 'rating' => '5.0', 'sessions' => 156, 'price' => 'S/ 90/hora'],
        ['name' => 'José Ramírez', 'role' => 'Marketing Strategist', 'initial' => 'J', 'rating' => '4.7', 'sessions' => 89, 'price' => 'S/ 75/hora'],
    ];
?>

<?php $__env->startSection('content'); ?>
<div class="home-page">
    <section class="home-hero-grid">
        <div class="home-hero-card">
            <span class="home-hero-badge">&#10024; Plataforma educativa</span>
            <h1 class="home-hero-title">Aprende de expertos o comparte tu <span>conocimiento</span></h1>
            <p class="home-hero-subtitle">
                Accede a más de 500 cursos y conecta con mentores profesionales para impulsar tu crecimiento profesional.
            </p>

            <form class="home-hero-form" action="<?php echo e(route('home')); ?>" method="GET">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" name="q" placeholder="¿Qué quieres aprender hoy?" aria-label="Buscar cursos o mentorías">
                <button type="submit" class="home-btn-primary" style="padding: 12px 28px;">Buscar</button>
            </form>

            <div class="home-hero-buttons">
                <a class="home-btn-primary" href="<?php echo e(url('/cursos')); ?>">Ver cursos publicados</a>
                <a class="home-btn-secondary" href="<?php echo e(route('mentor-market.index')); ?>">Ver mentorías</a>
            </div>

            <div class="home-hero-stats">
                <div class="home-hero-stat">
                    <span>500+</span>
                    <p>Cursos</p>
                </div>
                <div class="home-hero-stat">
                    <span>10K+</span>
                    <p>Estudiantes</p>
                </div>
                <div class="home-hero-stat">
                    <span>4.8&#9733;</span>
                    <p>Valoración</p>
                </div>
                <div class="home-hero-stat">
                    <span>95%</span>
                    <p>Finalizados</p>
                </div>
            </div>
        </div>

        <div class="home-hero-media" aria-hidden="true">
            <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=900&q=80" alt="Estudiante graduada">
        </div>
    </section>

    <section class="home-section">
        <div class="home-section-header">
            <div>
                <span class="home-section-badge">&#127919; Categorías destacadas</span>
                <h2 class="home-section-title">Explora por categoría</h2>
            </div>
            <a class="home-btn-secondary" href="<?php echo e(url('/cursos')); ?>">Ver todos &rarr;</a>
        </div>
        <div class="home-category-grid">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="home-category-card">
                    <div class="home-category-icon">
                        <img src="<?php echo e($category['icon']); ?>" alt="<?php echo e($category['name']); ?>">
                    </div>
                    <h3><?php echo e($category['name']); ?></h3>
                    <p><?php echo e($category['courses']); ?></p>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="home-section">
        <div class="home-section-header">
            <div>
                <span class="home-section-badge">&#128293; Contenido curado</span>
                <h2 class="home-section-title">Cursos más populares</h2>
            </div>
            <a class="home-btn-secondary" href="<?php echo e(url('/cursos')); ?>">Ver todos &rarr;</a>
        </div>
        <div class="home-course-grid">
            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="home-course-card">
                    <div class="home-course-image">
                        <img src="<?php echo e($course['image']); ?>" alt="<?php echo e($course['title']); ?>">
                    </div>
                    <div class="home-course-content">
                        <span class="home-course-category"><?php echo e($course['category']); ?></span>
                        <div>
                            <h3 class="home-course-title"><?php echo e($course['title']); ?></h3>
                            <p class="home-course-mentor">por <?php echo e($course['mentor']); ?></p>
                        </div>
                        <div class="home-course-meta">
                            <span>&#11088; <?php echo e($course['rating']); ?></span>
                            <span>&#128101; <?php echo e($course['students']); ?> estudiantes</span>
                        </div>
                        <div class="home-course-footer">
                            <p class="home-course-price"><?php echo e($course['price']); ?></p>
                            <a class="home-btn-primary" href="<?php echo e(url('/cursos')); ?>">Ver más &rarr;</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="home-section">
        <div class="home-section-header">
            <div>
                <span class="home-section-badge">&#11088; Mentorías destacadas</span>
                <h2 class="home-section-title">Aprende de los mejores</h2>
            </div>
            <a class="home-btn-secondary" href="<?php echo e(route('mentor-market.index')); ?>">Ver todos &rarr;</a>
        </div>
        <div class="home-mentor-grid">
            <?php $__currentLoopData = $mentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="home-mentor-card">
                    <div class="home-mentor-avatar"><?php echo e($mentor['initial']); ?></div>
                    <h3><?php echo e($mentor['name']); ?></h3>
                    <p><?php echo e($mentor['role']); ?></p>
                    <div class="home-mentor-stats">
                        <span>&#11088; <?php echo e($mentor['rating']); ?></span>
                        <span><?php echo e($mentor['sessions']); ?> sesiones</span>
                    </div>
                    <p class="home-mentor-price"><?php echo e($mentor['price']); ?></p>
                    <a class="home-btn-primary" href="<?php echo e(route('mentor-market.index')); ?>">Ver perfil &rarr;</a>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="home-cta">
        <div class="home-cta-grid">
            <div class="home-cta-block">
                <h2>¿Quieres aprender?</h2>
                <ul>
                    <li>Accede a cursos en vivo y on demand</li>
                    <li>Agenda mentorías personalizadas</li>
                    <li>Obtén certificados verificables</li>
                    <li>Aprende a tu propio ritmo</li>
                </ul>
                <a class="home-btn-secondary" href="<?php echo e(route('register')); ?>">Explorar cursos &rarr;</a>
            </div>
            <div class="home-cta-block">
                <h2>¿Quieres enseñar?</h2>
                <ul>
                    <li>Crea y vende tus propios cursos</li>
                    <li>Ofrece mentorías 1 a 1</li>
                    <li>Genera ingresos recurrentes</li>
                    <li>Construye tu comunidad</li>
                </ul>
                <a class="home-btn-secondary" href="<?php echo e(route('register')); ?>">Comenzar ahora &rarr;</a>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/home.blade.php ENDPATH**/ ?>
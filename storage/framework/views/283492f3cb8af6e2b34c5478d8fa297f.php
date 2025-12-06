<?php
    $cover = $curso->image_url
        ? (\Illuminate\Support\Str::startsWith($curso->image_url, ['http://', 'https://'])
            ? $curso->image_url
            : asset($curso->image_url))
        : null;
?>

<?php $__env->startPush('styles'); ?>
<style>
    .course-detail-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding: 40px 24px 96px;
    }

    .course-hero-section {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        border-radius: 32px;
        padding: 56px;
        color: #fff;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(108,71,255,0.3);
    }

    .course-hero-section::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(139,92,246,0.3), transparent 70%);
        border-radius: 50%;
    }

    .course-hero-content {
        position: relative;
        z-index: 1;
    }

    .course-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 999px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        backdrop-filter: blur(10px);
    }

    .course-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        margin: 20px 0;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .course-description {
        font-size: 1.15rem;
        line-height: 1.7;
        color: rgba(255,255,255,0.9);
        margin-bottom: 28px;
    }

    .course-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .course-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 32px;
        align-items: start;
    }

    .course-image-container {
        border-radius: 28px;
        overflow: hidden;
        background: #1e1b4b;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        margin-bottom: 32px;
    }

    .course-image-container img,
    .course-image-placeholder {
        width: 100%;
        height: 400px;
        object-fit: cover;
        display: block;
    }

    .course-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #374151, #1f2937);
        color: #9ca3af;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .course-section-card {
        background: #fff;
        border-radius: 24px;
        padding: 36px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(108,71,255,0.08);
        margin-bottom: 28px;
    }

    .section-title-with-icon {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(108,71,255,0.1), rgba(139,92,246,0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary);
    }

    .learning-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }

    .learning-item {
        display: flex;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(108,71,255,0.03), rgba(139,92,246,0.03));
        border: 1px solid rgba(108,71,255,0.08);
        color: #4b5563;
        font-size: 0.95rem;
    }

    .learning-icon {
        width: 24px;
        height: 24px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
    }

    .requirements-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .requirement-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 12px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .requirement-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--color-primary);
    }

    .instructor-card {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 24px;
        border-radius: 20px;
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border: 1px solid rgba(108,71,255,0.15);
    }

    .instructor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        color: #fff;
        font-size: 32px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 40px rgba(108,71,255,0.3);
    }

    .course-sidebar {
        position: sticky;
        top: 110px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .price-card {
        background: #fff;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        border: 1px solid rgba(108,71,255,0.1);
    }

    .price-header {
        text-align: center;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .price-label {
        font-size: 12px;
        letter-spacing: 0.08em;
        color: #9ca3af;
        font-weight: 700;
        text-transform: uppercase;
    }

    .price-amount {
        margin-top: 8px;
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }

    .price-actions {
        padding: 24px 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        border-radius: 14px;
        text-align: center;
        padding: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        color: #fff;
        box-shadow: 0 12px 35px rgba(108,71,255,0.35);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 45px rgba(108,71,255,0.4);
    }

    .btn-secondary {
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
        background: transparent;
    }

    .btn-secondary:hover {
        background: var(--color-primary);
        color: #fff;
    }

    .course-includes {
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .includes-title {
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 16px;
    }

    .includes-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .include-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.95rem;
        color: #4b5563;
    }

    .include-icon {
        width: 24px;
        height: 24px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(5,150,105,0.1));
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
    }

    .details-card {
        background: linear-gradient(135deg, #fff 0%, #fafbff 100%);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        border: 1px solid rgba(108,71,255,0.08);
    }

    .details-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-label {
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        color: #1f2937;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .course-main-grid {
            grid-template-columns: 1fr;
        }

        .course-sidebar {
            position: static;
        }

        .course-hero-section {
            padding: 40px 32px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="course-detail-wrapper">
        <section class="course-hero-section">
            <div class="course-hero-content">
                <span class="course-badge"><?php echo e($curso->category ?? 'Curso'); ?></span>
                <h1 class="course-title"><?php echo e($curso->title); ?></h1>
                <p class="course-description"><?php echo e($curso->description); ?></p>
                <div class="course-stats">
                    <span>⭐ 4.8 (1234 valoraciones)</span>
                    <span>👥 <?php echo e(number_format($curso->students_count ?? 0)); ?> estudiantes</span>
                    <span>⏱ <?php echo e($curso->duration); ?> horas</span>
                    <span>🌐 Español</span>
                </div>
            </div>
        </section>

        <div class="course-main-grid">
            <div>
                <div class="course-image-container">
                    <?php if($cover): ?>
                        <img src="<?php echo e($cover); ?>" alt="Imagen del curso <?php echo e($curso->title); ?>">
                    <?php else: ?>
                        <div class="course-image-placeholder">
                            Sin portada disponible
                        </div>
                    <?php endif; ?>
                </div>

                <article class="course-section-card">
                    <h2 class="section-title-with-icon">
                        <span class="section-icon">✨</span>
                        Lo que aprenderás
                    </h2>
                    <div class="learning-grid">
                        <div class="learning-item">
                            <div class="learning-icon">✓</div>
                            <span>Construir proyectos completos con <?php echo e($curso->title); ?></span>
                        </div>
                        <div class="learning-item">
                            <div class="learning-icon">✓</div>
                            <span>Buenas prácticas para escalar aplicaciones</span>
                        </div>
                        <div class="learning-item">
                            <div class="learning-icon">✓</div>
                            <span>Implementar flujos de pago, autenticación y despliegue</span>
                        </div>
                    </div>
                </article>

                <article class="course-section-card">
                    <h3 class="section-title-with-icon">
                        <span class="section-icon">📚</span>
                        Contenido del curso
                    </h3>
                    <p style="color: #6b7280; line-height: 1.7;">
                        Incluye módulos teóricos, prácticas guiadas y recursos descargables para avanzar paso a paso.
                    </p>
                </article>

                <article class="course-section-card">
                    <h3 class="section-title-with-icon">
                        <span class="section-icon">📋</span>
                        Requisitos
                    </h3>
                    <div class="requirements-list">
                        <div class="requirement-item">
                            <span class="requirement-dot"></span>
                            <span>Conocimientos básicos de programación</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-dot"></span>
                            <span>Laptop con al menos 4GB de RAM</span>
                        </div>
                        <div class="requirement-item">
                            <span class="requirement-dot"></span>
                            <span>Muchas ganas de aprender</span>
                        </div>
                    </div>
                </article>

                <article class="course-section-card">
                    <h2 class="section-title-with-icon">
                        <span class="section-icon">👨‍🏫</span>
                        Instructor
                    </h2>
                    <div class="instructor-card">
                        <div class="instructor-avatar">
                            <?php echo e(substr($curso->mentor->name ?? 'SN', 0, 1)); ?>

                        </div>
                        <div>
                            <p style="font-size: 1.2rem; font-weight: 700; color: #1f2937; margin: 0 0 6px;">
                                <?php echo e($curso->mentor->name ?? 'Mentor por asignar'); ?>

                            </p>
                            <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">
                                Especialista en <?php echo e($curso->category ?? 'la temática del curso'); ?>

                            </p>
                        </div>
                    </div>
                </article>
            </div>

            <aside class="course-sidebar">
                <div class="price-card">
                    <div class="price-header">
                        <div class="price-label">Precio</div>
                        <div class="price-amount">S/ <?php echo e(number_format($curso->price, 2)); ?></div>
                    </div>

                    <div class="price-actions">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if($curso->isPurchasedBy(auth()->user())): ?>
                                <a href="<?php echo e(route('courses.classroom', $curso)); ?>" class="btn-primary">Ir al aula</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('courses.checkout', $curso)); ?>" class="btn-primary">Comprar curso</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn-primary">Ingresa para inscribirte</a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $curso)): ?>
                            <a href="<?php echo e(route('cursos.editor', $curso)); ?>" class="btn-secondary">Editar curso</a>
                        <?php endif; ?>
                    </div>

                    <div class="course-includes">
                        <div class="includes-title">Este curso incluye:</div>
                        <div class="includes-list">
                            <div class="include-item">
                                <div class="include-icon">✓</div>
                                <span>Acceso de por vida</span>
                            </div>
                            <div class="include-item">
                                <div class="include-icon">✓</div>
                                <span>Recursos descargables</span>
                            </div>
                            <div class="include-item">
                                <div class="include-icon">✓</div>
                                <span>Certificado de finalización</span>
                            </div>
                            <div class="include-item">
                                <div class="include-icon">✓</div>
                                <span>Comunidad privada</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="details-card">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 0 0 20px;">Detalles</h3>
                    <div class="details-list">
                        <div class="detail-item">
                            <span class="detail-label">Duración aproximada</span>
                            <span class="detail-value"><?php echo e($curso->duration); ?> horas</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Mentor</span>
                            <span class="detail-value"><?php echo e($curso->mentor->name ?? 'No asignado'); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nivel</span>
                            <span class="detail-value"><?php echo e(ucfirst($curso->level ?? 'Todos')); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Estado</span>
                            <span class="detail-value"><?php echo e(ucfirst($curso->status)); ?></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/cursos/show.blade.php ENDPATH**/ ?>
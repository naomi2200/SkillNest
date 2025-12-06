<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary: #6c47ff;
            --primary-light: #f0edff;
            --secondary: #1f2937;
            --accent: #8b5cf6;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --white: #ffffff;
            --success: #10b981;
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-card: 0 25px 60px rgba(13, 10, 44, 0.08);
        }

        .mentor-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 64px;
        }

        .mentor-hero {
            background: #fff;
            border-radius: 32px;
            padding: clamp(32px, 4vw, 48px);
            box-shadow: 0 30px 80px rgba(108, 71, 255, 0.15);
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .mentor-hero::after {
            content: "";
            position: absolute;
            inset: 12px 12px auto auto;
            width: 160px;
            height: 32px;
            border-radius: 999px;
            border: 2px solid rgba(108, 71, 255, 0.15);
        }

        .mentor-avatar {
            width: 120px;
            height: 120px;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            font-size: 48px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 55px rgba(108, 71, 255, 0.3);
        }

        .mentor-info {
            flex: 1;
            min-width: 280px;
        }

        .mentor-badge {
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
            color: var(--primary);
            margin-bottom: 16px;
        }

        .mentor-name {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 8px;
        }

        .mentor-specialty {
            font-size: 1.15rem;
            color: var(--gray-600);
            margin-bottom: 20px;
        }

        .mentor-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .mentor-stat {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: var(--gray-50);
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .mentor-stat.highlight {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .mentor-pricing {
            background: var(--white);
            border-radius: 24px;
            padding: 24px;
            border: 2px solid var(--gray-200);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            min-width: 260px;
        }

        .mentor-pricing .label {
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gray-500);
        }

        .mentor-pricing .amount {
            font-size: 2rem;
            font-weight: 800;
            margin-top: 8px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mentor-grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            gap: 32px;
        }

        .mentor-content {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .content-card,
        .booking-sidebar {
            background: var(--white);
            border-radius: 28px;
            padding: clamp(24px, 3vw, 32px);
            box-shadow: var(--shadow-card);
            border: 2px solid transparent;
            transition: all 0.25s ease;
        }

        .content-card:hover,
        .booking-sidebar:hover {
            border-color: rgba(108, 71, 255, 0.4);
            box-shadow: 0 35px 90px rgba(108, 71, 255, 0.18);
            transform: translateY(-2px);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 16px;
        }

        .card-description {
            color: var(--gray-600);
            line-height: 1.7;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 14px;
            background: var(--gray-50);
            border-radius: var(--radius-lg);
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--gray-400);
        }

        .stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-top: 6px;
        }

        .skills-container,
        .categories-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .skill-tag,
        .category-tag {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .skill-tag {
            background: var(--primary-light);
            color: var(--primary);
        }

        .category-tag {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .courses-grid {
            display: grid;
            gap: 20px;
        }

        .course-item {
            background: var(--gray-50);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--gray-200);
        }

        .course-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--secondary);
        }

        .course-description {
            margin-top: 8px;
            color: var(--gray-500);
            line-height: 1.6;
        }

        .booking-sidebar {
            position: sticky;
            top: 24px;
        }

        .booking-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 12px;
        }

        .booking-description {
            color: var(--gray-500);
            margin-bottom: 24px;
        }

        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            border-radius: var(--radius);
            border: 1px solid var(--gray-300);
            background: #fff;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 71, 255, 0.1);
        }

        .pricing-breakdown {
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            padding: 20px;
            border: 1px solid var(--gray-200);
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            color: var(--gray-600);
        }

        .breakdown-total {
            border-top: 1px solid var(--gray-300);
            margin-top: 8px;
            padding-top: 8px;
            font-weight: 700;
            color: var(--secondary);
        }

        .btn {
            border-radius: var(--radius);
            padding: 14px;
            font-weight: 600;
            border: none;
            text-align: center;
            display: inline-flex;
            justify-content: center;
            width: 100%;
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            box-shadow: 0 15px 40px rgba(108, 71, 255, 0.35);
        }

        @media (max-width: 1024px) {
            .mentor-grid {
                grid-template-columns: 1fr;
            }

            .booking-sidebar {
                position: static;
            }
        }

        @media (max-width: 640px) {
            .mentor-hero {
                flex-direction: column;
                text-align: center;
            }

            .mentor-stats {
                justify-content: center;
            }

            .mentor-pricing {
                width: 100%;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php
    use Illuminate\Support\Str;

    $profile = $mentor->mentorProfile;
    $mentoria = $mentoria ?? null;
    $skills = array_filter(array_map('trim', explode(',', (string) ($profile->skills ?? ''))));
    $categories = array_filter(array_map('trim', explode(',', (string) ($profile->categorias ?? ''))));
    $mentoriaPrice = optional($mentoria)->precio ?? optional($mentoria)->monto ?? ($profile->precio_hora ?? 0);
    $mentoriaDuration = optional($mentoria)->duracion_minutos ?? 60;
    $specialty = optional($mentoria)->especialidad ?? ($profile->profesion ?? 'Mentor SkillNest');
    $modalidad = optional($mentoria)->modalidad ? ucfirst(optional($mentoria)->modalidad) : 'Modalidad no definida';
    $experienceLabels = [
        'junior' => 'Junior (0-2 años)',
        'mid' => 'Intermedio (3-6 años)',
        'senior' => 'Senior (7+ años)',
    ];
    $experienceLabel = $profile?->nivel_experiencia
        ? ($experienceLabels[$profile->nivel_experiencia] ?? ucfirst($profile->nivel_experiencia))
        : 'Nivel no especificado';
?>

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary: #7c3aed;
            --primary-2: #8b5cf6;
        }
        body {
            background: radial-gradient(circle at 15% 20%, rgba(124,58,237,0.08), transparent 30%),
                        radial-gradient(circle at 80% 0%, rgba(124,58,237,0.08), transparent 30%),
                        #f5f3ff;
        }
        .page-shell { max-width: 1180px; margin: 0 auto; padding: 32px 16px 64px; }
        .hero-card {
            background: #fff;
            border-radius: 30px;
            padding: 28px;
            border: 1px solid rgba(124,58,237,0.1);
            box-shadow: 0 24px 60px rgba(124,58,237,0.12);
        }
        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(124,58,237,0.08);
            color: #6d28d9;
            font-weight: 700;
            font-size: 12px;
        }
        .avatar {
            width: 78px;
            height: 78px;
            border-radius: 22px;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(124,58,237,0.08);
            color: #6d28d9;
            font-weight: 700;
            font-size: 13px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(160px,1fr));
            gap: 12px;
            margin-top: 16px;
        }
        .meta-card {
            background: #f8fafc;
            border: 1px solid rgba(124,58,237,0.08);
            border-radius: 14px;
            padding: 12px 14px;
        }
        .meta-card p { margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.12em; color: #94a3b8; }
        .meta-card strong { display: block; margin-top: 4px; font-size: 15px; color: #1f2937; }

        .section-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(124,58,237,0.08);
            box-shadow: 0 16px 40px rgba(124,58,237,0.08);
            padding: 22px;
        }
        .section-card h2 { font-size: 18px; font-weight: 800; color: #1f2937; margin-bottom: 10px; }
        .section-card h3 { font-size: 16px; font-weight: 800; color: #1f2937; margin-top: 14px; }
        .chip {
            display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px;
            background: rgba(124,58,237,0.1); color:#6d28d9; font-weight:700; font-size:12px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #fff;
            border: none;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 10px 28px rgba(124,58,237,0.18);
        }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .info-table td { padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; color: #1f2937; }
        .info-table td:first-child { color: #6b7280; width: 45%; font-weight: 600; }
        .form-label { display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:6px; }
        .form-input {
            width: 100%; border:1px solid #e5e7eb; border-radius:12px; padding:10px 12px;
            background:#fff; color:#111827;
        }
        .form-input:focus { outline: 2px solid rgba(124,58,237,0.3); border-color: rgba(124,58,237,0.5); }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="mentor-container">
        <section class="mentor-hero">
            <div class="mentor-avatar">
                <?php echo e(strtoupper(Str::substr($mentor->name ?? 'S', 0, 1))); ?>

            </div>
            <div class="mentor-info">
                <div class="mentor-badge">Mentor verificado</div>
                <h1 class="mentor-name"><?php echo e($mentor->name); ?></h1>
                <p class="mentor-specialty"><?php echo e($specialty); ?></p>
                <div class="mentor-stats">
                    <span class="mentor-stat">
                        ★ <?php echo e(number_format($mentor->rating ?? 4.8, 1)); ?>

                        • <?php echo e($mentor->sessions_count ?? 0); ?> sesiones
                    </span>
                    <span class="mentor-stat">
                        ⏱ <?php echo e($profile->experiencia_anios ?? 0); ?> años experiencia
                    </span>
                    <span class="mentor-stat highlight">
                        <?php echo e(optional($mentoria)->estado === 'publicada' ? 'Disponible' : 'Agenda cerrada'); ?>

                    </span>
                </div>
            </div>
            <div class="mentor-pricing">
                <p class="label">Tarifa por sesión</p>
                <p class="amount">S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></p>
                <p class="label" style="margin-top: 4px;"><?php echo e($mentoriaDuration); ?> minutos • <?php echo e($modalidad); ?></p>
            </div>
        </section>

        <div class="mentor-grid">
            <div class="mentor-content">
                <section class="content-card">
                    <h2 class="card-title">Acerca de mí</h2>
                    <p class="card-description">
                        <?php echo e($profile->descripcion ?? 'Este mentor aún no ha completado su biografía.'); ?>

                    </p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <p class="stat-label">Especialidad</p>
                            <p class="stat-value"><?php echo e($specialty); ?></p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-label">Experiencia</p>
                            <p class="stat-value"><?php echo e($experienceLabel); ?></p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-label">Modalidad</p>
                            <p class="stat-value"><?php echo e($modalidad); ?></p>
                        </div>
                    </div>
                </section>

                <section class="content-card">
                    <h2 class="card-title">Habilidades técnicas</h2>
                    <?php if($skills): ?>
                        <div class="skills-container">
                            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="skill-tag"><?php echo e($skill); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="card-description">Aún no se registran habilidades.</div>
                    <?php endif; ?>
                </section>

                <section class="content-card">
                    <h2 class="card-title">Categorías destacadas</h2>
                    <?php if($categories): ?>
                        <div class="categories-container">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="category-tag"><?php echo e($category); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="card-description">Este mentor aún no define categorías.</div>
                    <?php endif; ?>
                </section>

                <section class="content-card">
                    <h2 class="card-title">Cursos dictados</h2>
                    <div class="courses-grid">
                        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <article class="course-item">
                                <p class="course-category"><?php echo e($course->category ?? 'Curso'); ?></p>
                                <h3 class="course-title"><?php echo e($course->title ?? $course->name); ?></h3>
                                <p class="course-description">
                                    <?php echo e($course->description ?? 'Detalles no disponibles.'); ?>

                                </p>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="card-description">Este mentor aún no tiene cursos públicos.</div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

            <aside class="booking-sidebar" id="booking">
                <h3 class="booking-title">Agenda tu mentoría</h3>
                <p class="booking-description">
                    Sesiones personalizadas 1:1. Comparte tus objetivos y define un plan junto a tu mentor.
                </p>

                <?php if(!auth()->check()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn">Inicia sesión para agendar</a>
                <?php elseif(auth()->user()->isMentor()): ?>
                    <div class="card-description text-sm">
                        Inicia sesión como estudiante para reservar una sesión.
                    </div>
                <?php elseif(!$mentoria || $mentoria->estado !== 'publicada'): ?>
                    <div class="card-description text-sm">
                        Este mentor no tiene sesiones disponibles por ahora.
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('mentor-market.book', $mentor)); ?>" class="booking-form">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-input" name="date" min="<?php echo e(now()->toDateString()); ?>" required>
                        </div>
                        <div>
                            <label class="form-label">Hora</label>
                            <input type="time" class="form-input" name="time" required>
                        </div>
                        <div>
                            <label class="form-label">Notas para el mentor</label>
                            <textarea class="form-input" rows="3" name="notes" placeholder="Cuéntale tus objetivos o contexto..."></textarea>
                        </div>

                        <?php
                            $serviceFee = round($mentoriaPrice * 0.05, 2);
                            $total = $mentoriaPrice + $serviceFee;
                        ?>

                        <div class="pricing-breakdown">
                            <div class="breakdown-item">
                                <span>Precio por sesión</span>
                                <span>S/ <?php echo e(number_format($mentoriaPrice, 2)); ?></span>
                            </div>
                            <div class="breakdown-item">
                                <span>Servicio SkillNest (5%)</span>
                                <span>S/ <?php echo e(number_format($serviceFee, 2)); ?></span>
                            </div>
                            <div class="breakdown-item breakdown-total">
                                <span>Total estimado</span>
                                <span>S/ <?php echo e(number_format($total, 2)); ?></span>
                            </div>
                        </div>

                        <button type="submit" class="btn">Agendar sesión</button>
                    </form>
                <?php endif; ?>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/mentor-market/show.blade.php ENDPATH**/ ?>
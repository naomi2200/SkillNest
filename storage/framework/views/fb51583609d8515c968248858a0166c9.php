<?php use Illuminate\Support\Str; ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .mentor-market {
            --primary: #3a57e8;
            --primary-light: #eef2ff;
            --secondary: #1e293b;
            --accent: #8b5cf6;
            --gray-100: #f8fafc;
            --gray-200: #f1f5f9;
            --gray-300: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --white: #ffffff;
            --shadow-card: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            --radius: 12px;
            --radius-xl: 32px;
            background: linear-gradient(135deg, #f5f7ff 0%, #f0f4ff 100%);
            border-radius: 36px;
            padding: clamp(24px, 4vw, 48px);
        }
        .mentor-market__container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .mentor-market header {
            text-align: center;
            margin-bottom: 40px;
            max-width: 720px;
            margin-left: auto;
            margin-right: auto;
        }
        .mentor-market .badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--primary);
            background-color: var(--primary-light);
            padding: 6px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
        }
        .mentor-market h1 {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 16px;
            line-height: 1.2;
        }
        .mentor-market .subtitle {
            font-size: 1.1rem;
            color: var(--gray-500);
        }
        .mentor-market .filter-section {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: clamp(24px, 3vw, 32px);
            margin-bottom: 48px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--gray-200);
            backdrop-filter: blur(10px);
        }
        .mentor-market .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }
        .mentor-market .filter-group {
            display: flex;
            flex-direction: column;
        }
        .mentor-market .filter-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gray-500);
            margin-bottom: 8px;
        }
        .mentor-market .form-input,
        .mentor-market .form-select {
            padding: 12px 16px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.2s ease;
            background-color: var(--white);
        }
        .mentor-market .form-input:focus,
        .mentor-market .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .mentor-market .filter-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 16px;
        }
        .mentor-market .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .mentor-market .btn-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: #fff;
            box-shadow: 0 10px 20px rgba(58, 87, 232, 0.25);
        }
        .mentor-market .btn-gradient:hover {
            transform: translateY(-2px);
        }
        .mentor-market .btn-secondary {
            background-color: var(--white);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }
        .mentor-market .btn-secondary:hover {
            background-color: var(--gray-100);
        }
        .mentor-market .mentor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
        }
        .mentor-market .mentor-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            padding: 24px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .mentor-market .mentor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
        }
        .mentor-market .mentor-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }
        .mentor-market .mentor-avatar {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .mentor-market .mentor-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: var(--primary);
            background-color: var(--primary-light);
            padding: 4px 10px;
            border-radius: 20px;
        }
        .mentor-market .mentor-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 24px;
            flex-grow: 1;
        }
        .mentor-market .detail-item {
            display: flex;
            justify-content: space-between;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.95rem;
        }
        .mentor-market .detail-label {
            font-weight: 500;
            color: var(--gray-600);
        }
        .mentor-market .detail-value {
            font-weight: 600;
            color: var(--secondary);
        }
        .mentor-market .price {
            color: var(--primary);
            font-weight: 700;
        }
        .mentor-market .mentor-actions {
            display: flex;
            gap: 12px;
            margin-top: auto;
        }
        .mentor-market .btn-primary {
            background-color: var(--primary);
            color: #fff;
            flex: 1;
            border: none;
        }
        .mentor-market .btn-primary:hover {
            background-color: #2d46c7;
        }
        .mentor-market .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            flex: 1;
        }
        .mentor-market .btn-outline:hover {
            background-color: var(--primary-light);
        }
        .mentor-market .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-xl);
            color: var(--gray-500);
        }
        @media (max-width: 768px) {
            .mentor-market {
                padding: 24px 16px;
            }
            .mentor-market .mentor-actions {
                flex-direction: column;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="mentor-market">
        <div class="mentor-market__container">
            <header>
                <span class="badge">Mentorías verificadas</span>
                <h1>Encuentra tu próxima mentoría</h1>
                <p class="subtitle">Filtra por especialidad, experiencia y modalidad para elegir la sesión ideal.</p>
            </header>

            <section class="filter-section">
                <form method="GET" class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">Categoría</label>
                        <select name="categoria" class="form-select">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['categoria'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Experiencia</label>
                        <select name="nivel" class="form-select">
                            <option value="">Cualquier nivel</option>
                            <?php $__currentLoopData = $experienceLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['nivel'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Modalidad</label>
                        <select name="modalidad" class="form-select">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $modalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['modalidad'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Precio mínimo</label>
                        <input type="number" name="precio_min" step="5" min="0" class="form-input"
                               value="<?php echo e($filters['precio_min'] ?? ''); ?>" placeholder="S/">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Precio máximo</label>
                        <input type="number" name="precio_max" step="5" min="0" class="form-input"
                               value="<?php echo e($filters['precio_max'] ?? ''); ?>" placeholder="S/">
                    </div>
                </form>
                <div class="filter-actions">
                    <button class="btn btn-gradient">Aplicar filtros</button>
                    <a href="<?php echo e(route('mentor-market.index')); ?>" class="btn btn-secondary">Limpiar</a>
                </div>
            </section>

            <section class="mentor-grid">
                <?php $__empty_1 = true; $__currentLoopData = $publicMentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $mentorUser = $mentoria->mentor;
                        $mentorProfile = $mentorUser?->mentorProfile;
                        $price = $mentoria->monto ?? $mentoria->precio;
                    ?>
                    <article class="mentor-card">
                        <div class="mentor-header">
                            <div class="mentor-avatar">
                                <?php echo e(strtoupper(Str::substr($mentorUser->name ?? 'S', 0, 1))); ?>

                            </div>
                            <div>
                                <h2><?php echo e($mentorUser->name ?? 'Mentor SkillNest'); ?></h2>
                                <span class="mentor-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Mentor verificado
                                </span>
                            </div>
                        </div>

                        <div class="mentor-details">
                            <div class="detail-item">
                                <span class="detail-label">Especialidad:</span>
                                <span class="detail-value"><?php echo e($mentoria->especialidad ?? $mentorProfile->profesion ?? 'Generalista'); ?></span>
                            </div>
                            <?php if($mentorProfile?->nivel_experiencia): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Nivel:</span>
                                    <span class="detail-value"><?php echo e($experienceLevels[$mentorProfile->nivel_experiencia] ?? ucfirst($mentorProfile->nivel_experiencia)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($mentorProfile?->categorias): ?>
                                <div class="detail-item">
                                    <span class="detail-label">Categorías:</span>
                                    <span class="detail-value"><?php echo e($mentorProfile->categorias); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="detail-item">
                                <span class="detail-label">Precio:</span>
                                <span class="detail-value price">S/ <?php echo e(number_format($price ?? 0, 2)); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Duración:</span>
                                <span class="detail-value"><?php echo e($mentoria->duracion_minutos); ?> min</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Modalidad:</span>
                                <span class="detail-value"><?php echo e(ucfirst($mentoria->modalidad)); ?></span>
                            </div>
                        </div>

                        <div class="mentor-actions">
                            <?php if($mentorUser): ?>
                                <a href="<?php echo e(route('mentor.public.show', $mentorUser->id)); ?>" class="btn btn-primary">Ver perfil</a>
                                <a href="<?php echo e(route('mentor.book.form', $mentorUser->id)); ?>" class="btn btn-outline">Agendar mentoría</a>
                            <?php else: ?>
                                <span class="text-xs text-gray-400">Mentor no disponible</span>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-state">
                        <h3>No encontramos mentorías con esos filtros.</h3>
                        <p>Ajusta los criterios e inténtalo de nuevo.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/mentor-market/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('student-title', 'Mis cursos'); ?>
<?php $__env->startSection('student-subtitle', 'Encuentra los cursos que has adquirido'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Scoped styles for the student courses page */
        .student-main .courses-page .tabs {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            background: #fff;
            padding: 0.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            width: fit-content;
        }

        .student-main .courses-page .tab-btn {
            background: transparent;
            color: #6b7280;
            border: none;
            padding: 0.65rem 1.25rem;
            border-radius: 0.65rem;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .student-main .courses-page .tab-btn.active { background: #6366f1; color: white; box-shadow: 0 2px 8px rgba(99,102,241,0.3); }

        .student-main .courses-page .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.75rem;
        }

        .student-main .courses-page .course-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .student-main .courses-page .course-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); border-color: #d1d5db; }

        .student-main .courses-page .course-banner { height: 140px; position: relative; display:flex; align-items:center; justify-content:center; overflow:hidden; }
        .student-main .courses-page .course-banner .course-icon { font-size: 3.25rem; filter: drop-shadow(0 4px 20px rgba(0,0,0,0.12)); }

        .student-main .courses-page .course-status { position:absolute; top:0.75rem; right:0.75rem; background: rgba(255,255,255,0.95); color:#6366f1; padding:0.3rem 0.8rem; border-radius:999px; font-size:0.8rem; font-weight:700; }
        .student-main .courses-page .course-status.completado { color:#10b981; }

        .student-main .courses-page .course-body { padding:1.25rem; }
        .student-main .courses-page .course-title { font-size:1.15rem; font-weight:700; color:#1f2937; margin-bottom:0.5rem; }
        .student-main .courses-page .course-meta { color:#6b7280; font-size:0.9rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem; }

        .student-main .courses-page .progress-bar-wrapper { background:#e5e7eb; height:10px; border-radius:999px; overflow:hidden; }
        .student-main .courses-page .progress-bar-fill { height:100%; border-radius:999px; transition: width 0.5s ease; }
        .student-main .courses-page .progress-blue { background: linear-gradient(90deg,#3b82f6,#6366f1); }

        .student-main .courses-page .btn-continue { width:100%; background: linear-gradient(135deg,#6366f1,#8b5cf6); color:white; border:none; padding:0.9rem; border-radius:0.75rem; font-weight:700; cursor:pointer; }
        .student-main .courses-page .btn-continue.pink { background: linear-gradient(135deg,#ec4899,#f43f5e); }

        .student-main .courses-page .empty-state { text-align:center; padding:3rem 1rem; color:#9ca3af; }
        .student-main .courses-page .empty-state i { font-size:3rem; margin-bottom:1rem; opacity:0.35; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="courses-page">
        <div class="page-header">
            <p class="breadcrumb">Panel estudiante</p>
            <h2 class="page-title">Mis cursos</h2>
            <p class="page-subtitle">Encuentra los cursos que has adquirido</p>
        </div>

        <div class="tabs" role="tablist" aria-label="Filtros de cursos">
            <?php
                $total = $courses->count();
                $inProgress = $courses->filter(fn($c) => ($c->pivot->progress ?? 0) < 100)->count();
                $completed = $courses->filter(fn($c) => ($c->pivot->progress ?? 0) >= 100)->count();
                $saved = 0;
            ?>
            <button class="tab-btn active" data-filter="all">Todos <span class="tab-badge"><?php echo e($total); ?></span></button>
            <button class="tab-btn" data-filter="progress">En Progreso <span class="tab-badge"><?php echo e($inProgress); ?></span></button>
            <button class="tab-btn" data-filter="completed">Completados <span class="tab-badge"><?php echo e($completed); ?></span></button>
            <button class="tab-btn" data-filter="saved">Guardados <span class="tab-badge"><?php echo e($saved); ?></span></button>
        </div>

        <?php if($courses->isEmpty()): ?>
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h3>No tienes cursos aún</h3>
                <p>Explora el catálogo y adquiere tu primer curso.</p>
            </div>
        <?php else: ?>
            <div class="courses-grid">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $progress = $course->pivot->progress ?? 0;
                        $mentor = $course->mentor->name ?? ($course->author->name ?? '—');
                        $modules = $course->modules_count ?? ($course->modules?->count() ?? null);
                        $bannerClasses = ['gradient-blue','gradient-pink','gradient-purple','gradient-orange'];
                        $banner = $bannerClasses[$idx % count($bannerClasses)];
                    ?>
                    <div class="course-card" data-progress="<?php echo e($progress); ?>">
                        <div class="course-banner <?php echo e($banner); ?>">
                            <div class="course-icon"><?php echo e($course->icon ?? '📚'); ?></div>
                            <span class="course-status <?php echo e($progress >= 100 ? 'completado' : ''); ?>"><?php echo e($progress >= 100 ? 'Completado' : 'En Progreso'); ?></span>
                        </div>
                        <div class="course-body">
                            <h3 class="course-title"><?php echo e($course->title ?? $course->name ?? 'Curso sin título'); ?></h3>
                            <p class="course-meta"><i class="fas fa-user"></i> <?php echo e($mentor); ?> • <?php echo e($modules ? $modules . ' módulos' : '— módulos'); ?></p>

                            <div class="course-progress-section">
                                <div class="progress-header">
                                    <span class="progress-label">Progreso</span>
                                    <span class="progress-value"><?php echo e($progress); ?>%</span>
                                </div>
                                <div class="progress-bar-wrapper">
                                    <div class="progress-bar-fill progress-blue" style="width: <?php echo e(intval($progress)); ?>%"></div>
                                </div>
                            </div>

                            <div class="course-rating">
                                <span class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </span>
                                <span class="rating-text"><?php echo e($course->rating ?? '4.8'); ?> (<?php echo e($course->reviews_count ?? '—'); ?>)</span>
                            </div>

                            <?php if($progress >= 100): ?>
                                <a href="<?php echo e(route('courses.classroom', $course->id)); ?>" class="btn-continue pink">Ver Certificado</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('courses.classroom', $course->id)); ?>" class="btn-continue">Continuar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function(){
            const tabs = document.querySelectorAll('.student-main .courses-page .tab-btn');
            const cards = document.querySelectorAll('.student-main .courses-page .course-card');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(){
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    cards.forEach(card => {
                        const progress = parseInt(card.dataset.progress || '0', 10);
                        let show = true;
                        if(filter === 'progress') show = progress < 100;
                        if(filter === 'completed') show = progress >= 100;
                        if(filter === 'saved') show = false; // no 'saved' metadata available
                        card.style.display = show ? '' : 'none';
                    });
                });
            });
        })();
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('student-title', 'Mis cursos'); ?>
<?php $__env->startSection('student-subtitle', 'Encuentra los cursos que has adquirido'); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="card">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-lg font-semibold text-secondary">Cursos activos</h2>
            <span class="text-sm text-slate-500"><?php echo e($courses->count()); ?> cursos</span>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="rounded-3xl border border-slate-100 bg-white/80 p-5 shadow-card">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo e($course->category); ?></p>
                    <h3 class="mt-1 text-xl font-semibold text-secondary"><?php echo e($course->title); ?></h3>
                    <p class="text-sm text-slate-500">Nivel <?php echo e(ucfirst($course->level)); ?> · <?php echo e($course->lessons_count ?? 0); ?> lecciones</p>

                    <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                        <span>Progreso</span>
                        <span class="font-semibold text-secondary"><?php echo e($course->pivot->progress ?? 0); ?>%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-primary" style="width: <?php echo e($course->pivot->progress ?? 0); ?>%;"></div>
                    </div>

                    <div class="mt-5 flex gap-3">
                        <a href="<?php echo e(route('courses.classroom', $course)); ?>"
                           class="btn-primary flex-1 justify-center">Continuar</a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="rounded-3xl border border-dashed border-slate-200 p-10 text-center text-slate-500 md:col-span-2">
                    Aún no tienes cursos inscritos.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/student/courses/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('student-title', 'Mis cursos'); ?>
<?php $__env->startSection('student-subtitle', 'Encuentra los cursos que has adquirido'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Dashboard de cursos estilo mentor, adaptado a estudiante (sin crear curso) */
        .student-main .courses-page { display:flex; flex-direction:column; gap:16px; }
        .student-main .courses-page .toolbar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap: 12px;
            background:#fff;
            padding: 12px 14px;
            border-radius: 18px;
            border:1px solid rgba(124,58,237,0.08);
            box-shadow:0 10px 30px rgba(124,58,237,0.06);
        }
        .student-main .courses-page .tabs {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            background: #fff;
            padding: 0.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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

        .student-main .courses-page .action-link {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:10px 14px;
            border-radius:12px;
            background: linear-gradient(135deg,#7c3aed,#8b5cf6);
            color:#fff;
            font-weight:800;
            text-decoration:none;
            box-shadow:0 10px 25px rgba(124,58,237,0.18);
        }

        .student-main .courses-page .table-card {
            background:#fff;
            border:1px solid rgba(124,58,237,0.12);
            border-radius:20px;
            box-shadow:0 16px 40px rgba(124,58,237,0.08);
            overflow:hidden;
        }
        .student-main .courses-page table { width:100%; border-collapse:collapse; }
        .student-main .courses-page thead { background:#f8fafc; }
        .student-main .courses-page th {
            padding:1rem 1.25rem;
            text-align:left;
            font-weight:700;
            font-size:0.85rem;
            text-transform:uppercase;
            letter-spacing:0.04em;
            color:#64748b;
        }
        .student-main .courses-page td {
            padding:1rem 1.25rem;
            border-top:1px solid #e5e7eb;
            color:#1f2937;
            vertical-align:middle;
            background:#fff;
        }
        .student-main .courses-page tr:hover td { background: rgba(124,58,237,0.03); }

        .student-main .courses-page .course-title { font-weight:800; color:#111827; margin:0; }
        .student-main .courses-page .course-meta { color:#6b7280; font-size:0.9rem; margin-top:4px; }
        .student-main .courses-page .badge {
            display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px;
            font-size:12px; font-weight:700;
        }
        .student-main .courses-page .badge-draft { background: rgba(148,163,184,0.18); color:#475569; }
        .student-main .courses-page .badge-progress { background: rgba(124,58,237,0.15); color:#6d28d9; }
        .student-main .courses-page .badge-done { background: rgba(16,185,129,0.18); color:#047857; }

        .student-main .courses-page .progress-wrap { background:#e5e7eb; height:10px; border-radius:999px; overflow:hidden; width:140px; }
        .student-main .courses-page .progress-bar { height:10px; border-radius:999px; background: linear-gradient(90deg,#7c3aed,#8b5cf6); }

        .student-main .courses-page .empty-state { text-align:center; padding:3rem 1rem; color:#9ca3af; }
        .student-main .courses-page .empty-state i { font-size:3rem; margin-bottom:1rem; opacity:0.35; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="courses-page">
        <div class="toolbar">
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
            <a href="<?php echo e(route('cursos.index')); ?>" class="action-link">Explorar cursos</a>
        </div>

        <?php if($courses->isEmpty()): ?>
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h3>No tienes cursos aún</h3>
                <p>Explora el catálogo y adquiere tu primer curso.</p>
            </div>
        <?php else: ?>
            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Progreso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $progress = $course->pivot->progress ?? 0;
                                $mentor = $course->mentor->name ?? ($course->author->name ?? 'Mentor');
                                $modules = $course->modules_count ?? ($course->modules?->count() ?? null);
                                $stateBadge = $progress >= 100 ? 'badge-done' : ($progress > 0 ? 'badge-progress' : 'badge-draft');
                                $stateLabel = $progress >= 100 ? 'Completado' : ($progress > 0 ? 'En progreso' : 'Pendiente');
                            ?>
                            <tr data-progress="<?php echo e($progress); ?>">
                                <td>
                                    <p class="course-title"><?php echo e($course->title ?? $course->name ?? 'Curso sin título'); ?></p>
                                    <p class="course-meta"><?php echo e($mentor); ?> · <?php echo e($modules ? $modules.' módulos' : 'Sin módulos'); ?></p>
                                </td>
                                <td>
                                    <div class="progress-wrap">
                                        <div class="progress-bar" style="width: <?php echo e(min(100, $progress)); ?>%;"></div>
                                    </div>
                                    <p class="course-meta" style="margin-top:6px;"><?php echo e($progress); ?>%</p>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($stateBadge); ?>"><?php echo e($stateLabel); ?></span>
                                </td>
                                <td>
                                    <div style="display:flex; gap:12px; align-items:center;">
                                        <a href="<?php echo e(route('courses.classroom', $course->id)); ?>" class="action-link" style="padding:8px 12px; box-shadow:none;">Continuar</a>
                                        <?php if(isset($course->classroom_url)): ?>
                                            <a href="<?php echo e($course->classroom_url); ?>" class="text-primary font-semibold" target="_blank" rel="noopener">Aula</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function(){
            const tabs = document.querySelectorAll('.student-main .courses-page .tab-btn');
            const rows = document.querySelectorAll('.student-main .courses-page tbody tr');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(){
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    rows.forEach(row => {
                        const progress = parseInt(row.dataset.progress || '0', 10);
                        let show = true;
                        if(filter === 'progress') show = progress < 100;
                        if(filter === 'completed') show = progress >= 100;
                        if(filter === 'saved') show = false; // sin guardados
                        row.style.display = show ? '' : 'none';
                    });
                });
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/student/courses/index.blade.php ENDPATH**/ ?>
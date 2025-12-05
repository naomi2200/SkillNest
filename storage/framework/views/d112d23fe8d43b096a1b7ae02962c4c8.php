<?php $__env->startSection('student-title', 'Mis mentorías'); ?>
<?php $__env->startSection('student-subtitle', 'Explora y gestiona todo tu ecosistema SkillNest'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Scoped styles for student mentorías (matching courses palette) */
        .student-main .mentorias-page .tabs { display:flex; gap:.75rem; margin-bottom:2rem; flex-wrap:wrap; background:#fff; padding:.5rem; border-radius:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.04); width:fit-content; }
        .student-main .mentorias-page .tab-btn { background:transparent; color:#6b7280; border:none; padding:.65rem 1.25rem; border-radius:.65rem; font-weight:600; font-size:.9rem; cursor:pointer; }
        .student-main .mentorias-page .tab-btn.active { background:#6366f1; color:#fff; box-shadow:0 2px 8px rgba(99,102,241,0.3); }

        .student-main .mentorias-page .btn-nueva-sesion { background: linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; padding:.75rem 1.5rem; border-radius:.75rem; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:.5rem; text-decoration:none; }

        .student-main .mentorias-page .mentorship-table { background:#fff; border-radius:1.25rem; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:3rem; }
        .student-main .mentorias-page table { width:100%; border-collapse:collapse; }
        .student-main .mentorias-page thead { background:#f9fafb; border-bottom:2px solid #e5e7eb; }
        .student-main .mentorias-page th { padding:1.25rem 1.5rem; text-align:left; font-weight:700; font-size:.85rem; text-transform:uppercase; color:#6b7280; }
        .student-main .mentorias-page td { padding:1.25rem 1.5rem; color:#374151; font-size:.95rem; }
        .student-main .mentorias-page tbody tr:hover { background:#f9fafb; }

        .student-main .mentorias-page .mentor-info { display:flex; align-items:center; gap:1rem; }
        .student-main .mentorias-page .mentor-avatar { width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff; }
        .student-main .mentorias-page .mentor-avatar.blue { background: linear-gradient(135deg,#3b82f6,#6366f1); }
        .student-main .mentorias-page .mentor-avatar.pink { background: linear-gradient(135deg,#ec4899,#f43f5e); }
        .student-main .mentorias-page .mentor-avatar.purple { background: linear-gradient(135deg,#8b5cf6,#a78bfa); }

        .student-main .mentorias-page .badge { padding:.4rem 1rem; border-radius:999px; font-size:.8rem; font-weight:700; display:inline-block; }
        .student-main .mentorias-page .badge.confirmada { background: rgba(16,185,129,0.15); color:#10b981; }
        .student-main .mentorias-page .badge.pendiente { background: rgba(245,158,11,0.15); color:#f59e0b; }

        .student-main .mentorias-page .action-buttons { display:flex; gap:.75rem; flex-wrap:wrap; }
        .student-main .mentorias-page .btn-action { padding:.5rem 1rem; border-radius:.65rem; font-size:.85rem; font-weight:600; border:none; cursor:pointer; transition:all .2s ease; }
        .student-main .mentorias-page .btn-unirse { background: rgba(59,130,246,0.15); color:#2563eb; }
        .student-main .mentorias-page .btn-pay { background: linear-gradient(135deg,#6c47ff,#8b5cf6); color:#fff; box-shadow:0 10px 25px rgba(108,71,255,.25); }
        .student-main .mentorias-page .btn-reagendar { background: rgba(107,114,128,0.15); color:#6b7280; }
        .student-main .mentorias-page .btn-disabled { background: rgba(226,232,240,0.8); color:#94a3b8; cursor:not-allowed; }

        .student-main .mentorias-page .mentors-section { margin-top:3rem; }
        .student-main .mentorias-page .mentors-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:2rem; }
        .student-main .mentorias-page .mentor-card { background:#fff; border:1px solid #e5e7eb; border-radius:1.25rem; padding:2rem; text-align:center; }

        .student-main .mentorias-page .empty-state { text-align:center; padding:3rem; color:#9ca3af; }
        .student-main .mentorias-page .empty-state i { font-size:3rem; margin-bottom:1rem; opacity:.3; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('student-content'); ?>
    
    <div class="mentorias-page">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <div class="tabs" role="tablist">
                <button class="tab-btn active" data-filter="all">Todas</button>
                <button class="tab-btn" data-filter="confirmadas">Confirmadas</button>
                <button class="tab-btn" data-filter="pendientes">Pendientes</button>
            </div>
            <a href="<?php echo e(route('mentor.book.form', ['mentor' => 0])); ?>" class="btn-nueva-sesion">
                <i class="fas fa-plus"></i>
                Nueva Sesión
            </a>
        </div>

        
        <?php if($mentorias->isEmpty()): ?>
            <div class="mentorship-table">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No tienes mentorías aún</h3>
                    <p>Explora los mentores disponibles y programa tu primera mentoría.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="mentorship-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mentor</th>
                            <th>Especialidad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $mentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $mentor = $mentoria->mentor;
                                $estado = $mentoria->estado ?? 'pendiente';
                                $puedePagar = $estado === 'aceptada' && $mentoria->payment_status !== 'paid';
                                $puedeUnirse = in_array($estado, ['pagada', 'confirmada', 'completada'], true) && $mentoria->session_link;
                                $estadoBadge = in_array($estado, ['pagada','confirmada','completada'], true) ? 'confirmada' : 'pendiente';
                            ?>
                            <tr data-estado="<?php echo e($estado); ?>">
                                <td>
                                    <div class="mentor-info">
                                        <div class="mentor-avatar <?php echo e($loop->index % 3 == 0 ? 'blue' : ($loop->index % 3 == 1 ? 'pink' : 'purple')); ?>"><?php echo e(strtoupper(substr($mentor->name ?? 'M',0,2))); ?></div>
<<<<<<< HEAD
                                        <span class="mentor-name"><?php echo e($mentor->name ?? 'Mentor'); ?></span>
                                    </div>
                                </td>
                                <td><?php echo e($mentor->specialty ?? ($mentoria->especialidad ?? 'General')); ?></td>
                                <td><?php echo e(optional($mentoria)->fecha_programada ?? '—'); ?></td>
                                <td><?php echo e(optional($mentoria)->hora_programada ?? '—'); ?></td>
                                <td><span class="badge <?php echo e($estado === 'confirmada' ? 'confirmada' : 'pendiente'); ?>"><?php echo e(ucfirst($estado)); ?></span></td>
=======
                                        <span class="mentor-name"><?php echo e($mentor->name ?? 'Mentor SkillNest'); ?></span>
                                    </div>
                                </td>
                                <td><?php echo e($mentor->specialty ?? ($mentoria->especialidad ?? 'Sin definir')); ?></td>
                                <td><?php echo e(optional($mentoria)->fecha_programada ?? 'Por confirmar'); ?></td>
                                <td><?php echo e(optional($mentoria)->hora_programada ?? 'Por confirmar'); ?></td>
                                <td><span class="badge <?php echo e($estadoBadge); ?>"><?php echo e(ucfirst($estado)); ?></span></td>
>>>>>>> 29e038f (Describe brevemente tus cambios)
                                <td>
                                    <div class="action-buttons">
                                        <?php if($puedePagar): ?>
                                            <a href="<?php echo e(route('mentorias.payment.show', $mentoria->id)); ?>" class="btn-action btn-pay">Pagar mentor?a</a>
                                        <?php elseif($puedeUnirse): ?>
                                            <a href="<?php echo e(route('mentorias.join', $mentoria->id)); ?>" class="btn-action btn-unirse">Unirse</a>
                                        <?php else: ?>
                                            <button class="btn-action btn-disabled" type="button" disabled>Esperando</button>
                                        <?php endif; ?>
                                        <button class="btn-action btn-reagendar" type="button">Reagendar</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mentors-section">
            <h2 class="section-title">Busca un Mentor</h2>
            <div class="mentors-grid">
                <div class="mentor-card">
                    <div class="mentor-card-avatar blue">AG</div>
                    <h3 class="mentor-card-name">Ana García</h3>
                    <p class="mentor-card-role">Full Stack Developer</p>
                    <button class="btn-contact">Contactar</button>
                </div>

                <div class="mentor-card">
                    <div class="mentor-card-avatar pink">CR</div>
                    <h3 class="mentor-card-name">Carlos Ruiz</h3>
                    <p class="mentor-card-role">UX/UI Designer</p>
                    <button class="btn-contact">Contactar</button>
                </div>

                <div class="mentor-card">
                    <div class="mentor-card-avatar purple">LM</div>
                    <h3 class="mentor-card-name">Laura Martínez</h3>
                    <p class="mentor-card-role">Data Scientist</p>
                    <button class="btn-contact">Contactar</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function(){
            // Filtro en vivo para que el estudiante explore mentorías según estado (proceso secundario documentado).
            const tabs = document.querySelectorAll('.student-main .mentorias-page .tab-btn');
            const rows = document.querySelectorAll('.student-main .mentorias-page tbody tr');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(){
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    rows.forEach(r => {
                        const estado = r.dataset.estado || 'pendiente';
                        let show = true;
                        if(filter === 'confirmadas') show = estado === 'confirmada';
                        if(filter === 'pendientes') show = estado !== 'confirmada';
                        r.style.display = show ? '' : 'none';
                    });
                });
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/dashboard/student/mentorias.blade.php ENDPATH**/ ?>
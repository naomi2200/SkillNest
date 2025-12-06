<?php $__env->startSection('student-title', 'Mi Perfil'); ?>
<?php $__env->startSection('student-subtitle', 'Actualiza tus datos personales para mantener tu experiencia personalizada'); ?>

<?php $__env->startSection('student-content'); ?>
    <?php
        $avatar = $user->avatar_url
            ? (\Illuminate\Support\Str::startsWith($user->avatar_url, ['http://','https://'])
                ? $user->avatar_url
                : asset($user->avatar_url))
            : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'SkillNest').'&background=6366f1&color=fff';
    ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Profile page scoped styles (adapted to mentorías palette) */
        .student-main .profile-page .page-header { margin-bottom: 1rem; }
        .student-main .profile-page .page-title { font-size: 2rem; font-weight:800; color:#111827; }

        .student-main .profile-page .profile-header-card {
            background:#fff; border:1px solid #e5e7eb; border-radius:1rem; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.04); margin-bottom:1.5rem;
            display:flex; gap:1.25rem; align-items:center;
        }
        .student-main .profile-page .profile-avatar { width:96px; height:96px; border-radius:12px; object-fit:cover; box-shadow:0 8px 25px rgba(99,102,241,0.18); }
        .student-main .profile-page .btn-change-photo { background:#fff; color:#6366f1; border:2px solid #6366f1; padding:.5rem .75rem; border-radius:.5rem; font-weight:700; }

        .student-main .profile-page .profile-name { font-size:1.5rem; font-weight:800; color:#111827; }
        .student-main .profile-page .profile-subtitle { color:#6b7280; margin-bottom:.75rem; }
        .student-main .profile-page .profile-stats { display:flex; gap:1.5rem; }
        .student-main .profile-page .stat-label { color:#9ca3af; font-size:.75rem; font-weight:700; text-transform:uppercase; }
        .student-main .profile-page .stat-value { font-size:1.25rem; font-weight:800; color:#111827; }

        .student-main .profile-page .tabs { display:flex; gap:.5rem; margin-bottom:.75rem; }
        .student-main .profile-page .tab-btn { background:transparent; color:#6b7280; border:none; padding:.6rem 1rem; font-weight:700; cursor:pointer; border-radius:.6rem; }
        .student-main .profile-page .tab-btn.active { color:#fff; background:linear-gradient(135deg,#6366f1,#8b5cf6); box-shadow:0 4px 15px rgba(99,102,241,0.2); }

        .student-main .profile-page .form-section { background:#fff; border:1px solid #e5e7eb; border-radius:0 0 1rem 1rem; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .student-main .profile-page .form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:1rem; }
        .student-main .profile-page .form-label { font-weight:700; color:#374151; margin-bottom:.5rem; }
        .student-main .profile-page .form-input, .student-main .profile-page .form-select, .student-main .profile-page .form-textarea { background:#f9fafb; border:2px solid #e5e7eb; border-radius:.75rem; padding:.75rem 1rem; color:#374151; }
        .student-main .profile-page .form-input:focus, .student-main .profile-page .form-select:focus, .student-main .profile-page .form-textarea:focus { outline:none; border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,0.06); background:#fff; }

        .student-main .profile-page .btn-save { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; padding:.85rem 1.75rem; border-radius:.75rem; font-weight:800; }

        @media (max-width:1024px){ .student-main .profile-page .form-grid { grid-template-columns:1fr; } }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('student-content'); ?>
    <div class="profile-page">
        

        <?php
            $avatar = $user->avatar_url
                ? (\Illuminate\Support\Str::startsWith($user->avatar_url, ['http://','https://'])
                    ? $user->avatar_url
                    : asset($user->avatar_url))
                : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'SkillNest').'&background=6366f1&color=fff';
        ?>

        <div class="profile-header-card">
            <div style="display:flex; gap:1rem; align-items:center">
                <img src="<?php echo e($avatar); ?>" alt="Avatar" class="profile-avatar">
                <div style="display:flex; flex-direction:column">
                    <h2 class="profile-name"><?php echo e($user->name ?? 'Estudiante'); ?></h2>
                    <p class="profile-subtitle"><?php echo e($user->profile_title ?? 'Estudiante en SkillNest'); ?></p>
                    <div class="profile-stats" style="margin-top:.5rem">
                        <div class="stat-item">
                            <div class="stat-label">Miembro desde</div>
                            <div class="stat-value"><?php echo e(optional($user->created_at)->format('d M Y') ?? '—'); ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Cursos</div>
                            <div class="stat-value"><?php echo e($user->cursosInscritos?->count() ?? 0); ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Mentorías</div>
                            <div class="stat-value"><?php echo e($user->mentoriasComoEstudiante?->count() ?? 0); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-left:auto; display:flex; flex-direction:column; gap:.5rem; align-items:flex-end">
                <label for="avatar-input" class="btn-change-photo">Cambiar Foto</label>
                <a href="#" class="btn-save" style="padding:.5rem .85rem; font-size:.85rem">Ver mi perfil público</a>
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem">
            <div class="tabs" role="tablist">
                <button class="tab-btn active" data-tab="info">Información Personal</button>
                <button class="tab-btn" data-tab="prefs">Preferencias</button>
                <button class="tab-btn" data-tab="social">Redes Sociales</button>
            </div>
        </div>

        <form action="<?php echo e(route('student.profile.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*">

            <div class="form-section">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="name" class="form-input" value="<?php echo e(old('name', $user->name)); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-input" value="<?php echo e(old('email', $user->email)); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="phone" class="form-input" value="<?php echo e(old('phone', $user->phone)); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">País</label>
                        <select name="country" class="form-select">
                            <option value="">Selecciona un país</option>
                            <?php $__currentLoopData = ['colombia'=>'Colombia','peru'=>'Perú','mexico'=>'México','argentina'=>'Argentina','chile'=>'Chile']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k); ?>" <?php if(old('country', $user->country) == $k): echo 'selected'; endif; ?>><?php echo e($v); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Especialidad Actual</label>
                        <select name="specialty" class="form-select">
                            <option value="">Selecciona una especialidad</option>
                            <option value="fullstack" <?php if(old('specialty', $user->specialty)=='fullstack'): echo 'selected'; endif; ?>>Full Stack Development</option>
                            <option value="frontend" <?php if(old('specialty', $user->specialty)=='frontend'): echo 'selected'; endif; ?>>Frontend Development</option>
                            <option value="backend" <?php if(old('specialty', $user->specialty)=='backend'): echo 'selected'; endif; ?>>Backend Development</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nivel de Experiencia</label>
                        <select name="profile_level" class="form-select">
                            <?php $__currentLoopData = ['principiante','intermedio','avanzado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($level); ?>" <?php if(old('profile_level', $user->profile_level ?? 'principiante') === $level): echo 'selected'; endif; ?>><?php echo e(ucfirst($level)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Biografía</label>
                        <textarea name="bio" class="form-textarea"><?php echo e(old('bio', $user->bio)); ?></textarea>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:1rem">
                    <a href="#" class="btn-change-photo" style="background:#fff; border:2px solid #e5e7eb; color:#374151">Cancelar</a>
                    <button type="submit" class="btn-save">Guardar Cambios</button>
                </div>
            </div>
        </form>

        <script>
            (function(){
                const tabs = document.querySelectorAll('.student-main .profile-page .tab-btn');
                tabs.forEach(tab => tab.addEventListener('click', function(){ tabs.forEach(t=>t.classList.remove('active')); this.classList.add('active'); }));

                document.getElementById('avatar-input')?.addEventListener('change', (event) => {
                    const file = event.target.files?.[0]; if(!file) return;
                    const preview = document.querySelector('.student-main .profile-page img[alt="Avatar"]');
                    if(preview){ const url = URL.createObjectURL(file); preview.src = url; setTimeout(()=>URL.revokeObjectURL(url),5000); }
                });
            })();
        </script>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/student/profile.blade.php ENDPATH**/ ?>
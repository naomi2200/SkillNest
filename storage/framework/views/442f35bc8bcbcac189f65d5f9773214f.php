<?php use Illuminate\Support\Str; ?>

<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-6xl space-y-8">
        <header class="space-y-2 text-center">
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Mentorías verificadas</p>
            <h1 class="text-4xl font-semibold text-secondary">Encuentra tu próxima mentoría</h1>
            <p class="text-slate-500">Filtra por especialidad, experiencia y modalidad para elegir la sesión ideal.</p>
        </header>

        <section class="rounded-[32px] border border-slate-100 bg-white/90 p-6 shadow-card">
            <form method="GET" class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Categoría</label>
                    <select name="categoria" class="form-input mt-2">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['categoria'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Experiencia</label>
                    <select name="nivel" class="form-input mt-2">
                        <option value="">Cualquier nivel</option>
                        <?php $__currentLoopData = $experienceLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['nivel'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Modalidad</label>
                    <select name="modalidad" class="form-input mt-2">
                        <option value="">Todas</option>
                        <?php $__currentLoopData = $modalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['modalidad'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Precio mínimo</label>
                    <input type="number" name="precio_min" step="5" min="0" class="form-input mt-2"
                           value="<?php echo e($filters['precio_min'] ?? ''); ?>" placeholder="S/">
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Precio máximo</label>
                    <input type="number" name="precio_max" step="5" min="0" class="form-input mt-2"
                           value="<?php echo e($filters['precio_max'] ?? ''); ?>" placeholder="S/">
                </div>
                <div class="md:col-span-2 lg:col-span-4 flex flex-wrap gap-3">
                    <button class="btn-gradient">Aplicar filtros</button>
                    <a href="<?php echo e(route('mentor-market.index')); ?>" class="btn-secondary">Limpiar</a>
                </div>
            </form>
        </section>

        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php $__empty_1 = true; $__currentLoopData = $publicMentorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $mentorUser = $mentoria->mentor;
                    $mentorProfile = $mentorUser?->mentorProfile;
                    $price = $mentoria->monto ?? $mentoria->precio;
                ?>
                <article class="flex h-full flex-col rounded-[30px] border border-slate-100 bg-white/95 p-6 shadow-card">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-xl font-semibold text-primary">
                            <?php echo e(strtoupper(Str::substr($mentorUser->name ?? 'S', 0, 1))); ?>

                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-secondary"><?php echo e($mentorUser->name ?? 'Mentor SkillNest'); ?></h2>
                            <p class="text-sm text-slate-500">Mentor verificado</p>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-2 text-sm text-slate-600">
                        <p>
                            <strong class="text-secondary">Especialidad:</strong>
                            <?php echo e($mentoria->especialidad ?? $mentorProfile->profesion ?? 'Generalista'); ?>

                        </p>
                        <?php if($mentorProfile?->nivel_experiencia): ?>
                            <p>
                                <strong class="text-secondary">Nivel:</strong>
                                <?php echo e($experienceLevels[$mentorProfile->nivel_experiencia] ?? ucfirst($mentorProfile->nivel_experiencia)); ?>

                            </p>
                        <?php endif; ?>
                        <?php if($mentorProfile?->categorias): ?>
                            <p>
                                <strong class="text-secondary">Categorias:</strong>
                                <?php echo e($mentorProfile->categorias); ?>

                            </p>
                        <?php endif; ?>
                        <p><strong class="text-secondary">Precio:</strong> S/ <?php echo e(number_format($price ?? 0, 2)); ?></p>
                        <p><strong class="text-secondary">Duración:</strong> <?php echo e($mentoria->duracion_minutos); ?> min</p>
                        <p><strong class="text-secondary">Modalidad:</strong> <?php echo e(ucfirst($mentoria->modalidad)); ?></p>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <?php if($mentorUser): ?>
                            <a href="<?php echo e(route('mentor.public.show', $mentorUser->id)); ?>" class="btn-primary flex-1 justify-center">
                                Ver perfil
                            </a>
                            <a href="<?php echo e(route('mentor.book.form', $mentorUser->id)); ?>" class="btn-secondary flex-1 justify-center">
                                Agendar mentoría
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-slate-400">Mentor no disponible</span>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="md:col-span-2 lg:col-span-3 rounded-[30px] border border-dashed border-slate-200 p-12 text-center text-slate-500">
                    No encontramos mentorías con esos filtros. Ajusta los criterios e inténtalo de nuevo.
                </div>
            <?php endif; ?>
        </section>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/mentor-market/index.blade.php ENDPATH**/ ?>
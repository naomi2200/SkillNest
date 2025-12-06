<?php $__env->startSection('mentor-title', 'Editar mentoría'); ?>
<?php $__env->startSection('mentor-subtitle', 'Actualiza los detalles de tu sesión'); ?>

<?php $__env->startSection('mentor-content'); ?>
    <div class="card">
        <form action="<?php echo e(route('mentor.mentorias.update', $mentoria)); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-secondary">Título</label>
                    <input type="text" name="titulo" value="<?php echo e(old('titulo', $mentoria->titulo)); ?>"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Especialidad</label>
                    <input type="text" name="especialidad" value="<?php echo e(old('especialidad', $mentoria->especialidad)); ?>"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3">
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-secondary">Precio (S/)</label>
                    <input type="number" step="0.01" min="0" name="precio" value="<?php echo e(old('precio', $mentoria->precio)); ?>"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Duración (minutos)</label>
                    <input type="number" min="1" name="duracion_minutos" value="<?php echo e(old('duracion_minutos', $mentoria->duracion_minutos)); ?>"
                           class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-secondary">Modalidad</label>
                    <select name="modalidad" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required>
                        <option value="virtual" <?php if(old('modalidad', $mentoria->modalidad) === 'virtual'): echo 'selected'; endif; ?>>Virtual</option>
                        <option value="presencial" <?php if(old('modalidad', $mentoria->modalidad) === 'presencial'): echo 'selected'; endif; ?>>Presencial</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-secondary">Objetivos</label>
                    <textarea name="objetivos" rows="3" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3"><?php echo e(old('objetivos', $mentoria->objetivos)); ?></textarea>
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-secondary">Descripción</label>
                <textarea name="descripcion" rows="5" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3" required><?php echo e(old('descripcion', $mentoria->descripcion)); ?></textarea>
            </div>

            <div class="flex flex-wrap justify-end gap-3">
                <a href="<?php echo e(route('mentor.mentorias.index')); ?>" class="btn-secondary">Cancelar</a>
                <button class="btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mentor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\NADHIRA\Downloads\SkillNest\resources\views/mentor/mentorias/edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-4xl space-y-8 py-10">
        <div class="rounded-3xl bg-white p-8 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-400">Proceso de pago</p>
                    <h1 class="text-3xl font-bold text-secondary">Completa tu compra</h1>
                    <p class="text-sm text-slate-500">Curso seleccionado: <span class="font-semibold"><?php echo e($course->title); ?></span></p>
                </div>
                <div class="text-right">
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-400">Precio</p>
                    <p class="text-3xl font-bold text-primary">S/ <?php echo e(number_format($course->price, 2)); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('courses.purchase', $course)); ?>" method="POST" class="mt-8 space-y-6">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="amount" value="<?php echo e($course->price); ?>">

                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-secondary">Método de pago</p>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <?php $__currentLoopData = ['tarjeta' => 'Tarjeta', 'yape' => 'Yape', 'plin' => 'Plin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border p-3 text-sm font-semibold text-slate-600 hover:border-primary">
                                <input type="radio" name="payment_method" value="<?php echo e($method); ?>" class="text-primary focus:ring-primary" <?php echo e(old('payment_method', 'tarjeta') === $method ? 'checked' : ''); ?>>
                                <?php echo e($label); ?>

                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div id="card-fields" class="space-y-4">
                    <label class="block text-sm font-semibold text-secondary">
                        Nombre del titular
                        <input type="text" name="card_name" value="<?php echo e(old('card_name', auth()->user()->name)); ?>" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                    </label>
                    <label class="block text-sm font-semibold text-secondary">
                        Número de tarjeta
                        <input type="text" name="card_number" value="<?php echo e(old('card_number')); ?>" maxlength="16" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" placeholder="0000 0000 0000 0000">
                    </label>
                </div>

                <div id="wallet-fields" class="hidden space-y-4">
                    <label class="block text-sm font-semibold text-secondary">
                        Referencia o código de operación
                        <input type="text" name="reference" value="<?php echo e(old('reference')); ?>" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" placeholder="Ingrese el código de pago">
                    </label>
                </div>

                <?php if($errors->any()): ?>
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <button type="submit" class="btn-primary w-full justify-center rounded-2xl py-3 text-base">Confirmar pago</button>
            </form>
        </div>
    </div>

    <script>
        const methodInputs = document.querySelectorAll('input[name="payment_method"]');
        const cardFields = document.getElementById('card-fields');
        const walletFields = document.getElementById('wallet-fields');

        const toggleFields = () => {
            const value = document.querySelector('input[name="payment_method"]:checked')?.value;
            if (value === 'tarjeta') {
                cardFields.classList.remove('hidden');
                walletFields.classList.add('hidden');
            } else {
                cardFields.classList.add('hidden');
                walletFields.classList.remove('hidden');
            }
        };

        methodInputs.forEach(input => input.addEventListener('change', toggleFields));
        toggleFields();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/courses/checkout.blade.php ENDPATH**/ ?>
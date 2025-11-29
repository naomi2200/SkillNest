

<?php $__env->startSection('dashboard-title', 'Pagar mentoría'); ?>

<?php $__env->startSection('dashboard-content'); ?>
    <div class="mx-auto max-w-3xl space-y-6">
        <a href="<?php echo e(route('student.mentorias')); ?>" class="text-sm font-semibold text-secondary hover:underline">← Volver a mis mentorías</a>

        <div class="card space-y-6">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Mentor</p>
                <h1 class="text-3xl font-semibold text-secondary"><?php echo e($mentoria->mentor->name ?? 'Mentor SkillNest'); ?></h1>
                <p class="text-sm text-slate-500"><?php echo e($mentoria->especialidad ?? 'Generalista'); ?></p>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4 text-sm text-slate-600">
                <div class="flex justify-between">
                    <span>Monto total</span>
                    <strong class="text-secondary">S/ <?php echo e(number_format($monto, 2)); ?></strong>
                </div>
                <p class="mt-2 text-xs text-slate-400">Pago simulado (Perú). Completa los datos para registrar tu pago.</p>
            </div>

            <?php
                $selectedMethod = old('metodo');
                $showCapture = in_array($selectedMethod, ['yape', 'plin'], true);
                $showCard = $selectedMethod === 'tarjeta';
            ?>

            <form method="POST" action="<?php echo e(route('payments.store', $mentoria)); ?>" enctype="multipart/form-data" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="form-label">Método de pago</label>
                    <select name="metodo" id="metodo_pago" class="form-input" required>
                        <option value="">Selecciona un método</option>
                        <option value="yape" <?php if($selectedMethod === 'yape'): echo 'selected'; endif; ?>>Yape</option>
                        <option value="plin" <?php if($selectedMethod === 'plin'): echo 'selected'; endif; ?>>Plin</option>
                        <option value="tarjeta" <?php if($selectedMethod === 'tarjeta'): echo 'selected'; endif; ?>>Tarjeta</option>
                    </select>
                </div>

                <div id="capture_wrapper" style="display: <?php echo e($showCapture ? 'block' : 'none'); ?>;">
                    <label class="form-label">Captura o comprobante (obligatorio para Yape/Plin)</label>
                    <input type="file" name="comprobante" class="form-input" accept="image/*">
                </div>

                <div id="tarjeta_wrapper" style="display: <?php echo e($showCard ? 'block' : 'none'); ?>;">
                    <label class="form-label">Número de tarjeta (16 dígitos si pagas con tarjeta)</label>
                    <input type="text" name="numero_tarjeta" class="form-input" placeholder="0000 0000 0000 0000" maxlength="16" inputmode="numeric" pattern="\d{16}">
                </div>

                <button class="btn-gradient w-full justify-center">Confirmar pago</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('metodo_pago');
            const captureWrapper = document.getElementById('capture_wrapper');
            const cardWrapper = document.getElementById('tarjeta_wrapper');

            const toggleFields = () => {
                const method = select.value;
                captureWrapper.style.display = (method === 'yape' || method === 'plin') ? 'block' : 'none';
                cardWrapper.style.display = method === 'tarjeta' ? 'block' : 'none';
            };

            select.addEventListener('change', toggleFields);
            toggleFields();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/payments/pay.blade.php ENDPATH**/ ?>
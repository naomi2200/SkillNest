<?php
    $defaultMetodo = old('metodo', 'yape');
    $metodoEsTarjeta = $defaultMetodo === 'tarjeta';
?>

<?php $__env->startPush('styles'); ?>
    <style>
        .pay-shell {
            padding: clamp(24px, 4vw, 48px);
            background: linear-gradient(135deg, #f5f7ff 0%, #fef6ff 100%);
        }
        .pay-hero {
            background: #fff;
            border-radius: 28px;
            padding: clamp(24px, 3vw, 36px);
            box-shadow: 0 25px 60px rgba(108,71,255,0.12);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
        }
        .pay-hero h1 {
            font-size: clamp(2rem, 3vw, 2.5rem);
            margin: 0;
            color: #1f2937;
            font-weight: 800;
        }
        .pay-hero p {
            margin: 6px 0 0;
            color: #6b7280;
        }
        .pay-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.8fr);
            gap: 32px;
        }
        .pay-panel {
            background: #fff;
            border-radius: 32px;
            padding: clamp(24px, 3vw, 40px);
            box-shadow: 0 35px 90px rgba(15,23,42,0.08);
        }
        .pay-summary {
            position: sticky;
            top: 32px;
            align-self: flex-start;
        }
        .pay-section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .pay-section-subtitle {
            color: #94a3b8;
            margin-bottom: 24px;
        }
        .method-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .hidden { display: none !important; }
        .method-card {
            border: 2px solid #e0e7ff;
            border-radius: 20px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            transition: all .2s ease;
            background: #fafbff;
        }
        .method-card input { display: none; }
        .method-card.active {
            border-color: transparent;
            background: linear-gradient(135deg, rgba(108,71,255,0.12), rgba(139,92,246,0.12));
            box-shadow: 0 15px 40px rgba(108,71,255,0.2);
        }
        .wallet-box {
            border: 2px dashed #d8b4fe;
            border-radius: 24px;
            padding: 28px;
            background: linear-gradient(135deg, #faf5ff, #f3e8ff);
            margin-bottom: 24px;
        }
        .wallet-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #7c3aed;
            letter-spacing: 2px;
            text-align: center;
        }
        .wallet-steps {
            margin: 16px 0 20px;
            color: #6b7280;
            line-height: 1.6;
            font-size: .95rem;
        }
        .upload-zone {
            width: 100%;
            padding: 14px;
            border: 2px dashed #cbd5f5;
            border-radius: 16px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            background: #fff;
        }
        .card-form {
            border-radius: 24px;
            border: 1px solid rgba(108,71,255,0.1);
            padding: 20px;
            background: #f8f9ff;
        }
        .pay-field {
            margin-top: 18px;
        }
        .pay-label {
            font-size: .9rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
        }
        .pay-input {
            width: 100%;
            border-radius: 14px;
            border: 1px solid #d4d6f2;
            padding: 12px 14px;
            font-size: .95rem;
            transition: border .2s ease;
        }
        .pay-input:focus {
            outline: none;
            border-color: #6c47ff;
            box-shadow: 0 0 0 3px rgba(108,71,255,0.1);
        }
        .pay-submit {
            width: 100%;
            margin-top: 28px;
            border: none;
            border-radius: 18px;
            padding: 16px;
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            background: linear-gradient(135deg, #6c47ff, #8b5cf6);
            box-shadow: 0 25px 60px rgba(108,71,255,0.3);
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .pay-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 70px rgba(108,71,255,0.35);
        }
        .summary-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 8px;
            color: #1f2937;
        }
        .summary-list {
            border-top: 1px solid #eceef9;
            margin-top: 12px;
            padding-top: 12px;
            font-size: .95rem;
            color: #475569;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            font-size: 1.4rem;
            font-weight: 800;
            color: #6c47ff;
        }
        .summary-safe {
            margin-top: 18px;
            padding: 12px;
            border-radius: 14px;
            background: rgba(16,185,129,0.1);
            color: #047857;
            font-weight: 600;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        @media (max-width: 1024px) {
            .pay-grid { grid-template-columns: 1fr; }
            .pay-summary { position: static; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="pay-shell">
        <section class="pay-hero">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-slate-400 font-semibold mb-2">Checkout</p>
                <h1>Confirma tu mentoría</h1>
                <p>Completa el pago para asegurar tu sesión con <?php echo e($mentoria->mentor->name ?? 'tu mentor'); ?>.</p>
            </div>
            <div class="text-right">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Monto</p>
                <p class="text-3xl font-extrabold text-slate-900">S/ <?php echo e(number_format($monto, 2)); ?></p>
            </div>
        </section>

        <div class="pay-grid">
            <section class="pay-panel">
                <h2 class="pay-section-title">Métodos de pago</h2>
                <p class="pay-section-subtitle">Selecciona el método que prefieras y sube tu comprobante si aplica.</p>

                <?php
                    $walletMethods = [
                        'yape' => ['icon' => '📱', 'label' => 'Yape', 'desc' => 'Pago instantáneo', 'number' => '923 456 789'],
                        'plin' => ['icon' => '📲', 'label' => 'Plin', 'desc' => 'Transferencia inmediata', 'number' => '987 654 321'],
                        'tarjeta' => ['icon' => '💳', 'label' => 'Tarjeta', 'desc' => 'Débito o crédito'],
                    ];
                ?>

                <form method="POST" action="<?php echo e(route('mentorias.payment.store', $mentoria->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="method-grid">
                        <?php $__currentLoopData = $walletMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="method-card <?php echo e($defaultMetodo === $method ? 'active' : ''); ?>" data-metodo="<?php echo e($method); ?>">
                                <input type="radio" name="metodo" value="<?php echo e($method); ?>" <?php echo e($defaultMetodo === $method ? 'checked' : ''); ?>>
                                <span style="font-size:1.8rem"><?php echo e($info['icon']); ?></span>
                                <strong><?php echo e($info['label']); ?></strong>
                                <span style="color:#6b7280; font-size:.9rem;"><?php echo e($info['desc']); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php $__currentLoopData = ['yape', 'plin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="wallet-box wallet-section <?php echo e($defaultMetodo === $wallet ? '' : 'hidden'); ?>" data-wallet="<?php echo e($wallet); ?>">
                            <div class="wallet-number"><?php echo e($walletMethods[$wallet]['number']); ?></div>
                            <p class="wallet-steps">
                                1. Realiza el pago usando <?php echo e(ucfirst($wallet)); ?><br>
                                2. Monto exacto: <strong>S/ <?php echo e(number_format($monto, 2)); ?></strong><br>
                                3. Adjunta tu comprobante para validar la operación
                            </p>
                            <input type="file" name="comprobante" id="comprobante-<?php echo e($wallet); ?>" accept="image/*" style="display:none;">
                            <label for="comprobante-<?php echo e($wallet); ?>" class="upload-zone">
                                📎 Subir comprobante
                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="card-form card-section <?php echo e($metodoEsTarjeta ? '' : 'hidden'); ?>">
                        <div class="pay-field">
                            <label class="pay-label">Número de tarjeta</label>
                            <input type="text" name="numero_tarjeta" value="<?php echo e(old('numero_tarjeta')); ?>" maxlength="16" class="pay-input" placeholder="0000 0000 0000 0000">
                        </div>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <button class="pay-submit">Confirmar pago</button>
                </form>
            </section>

            <aside class="pay-panel pay-summary summary-card">
                <h3>Resumen</h3>
                <p class="text-slate-500"><?php echo e($mentoria->mentor->name ?? 'Mentor SkillNest'); ?></p>
                <p class="text-sm text-slate-400"><?php echo e($mentoria->especialidad ?? 'Mentoría personalizada'); ?></p>

                <div class="summary-list">
                    <div class="summary-row">
                        <span>Monto de la mentoría</span>
                        <span>S/ <?php echo e(number_format($monto, 2)); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Comisión</span>
                        <span>S/ 0.00</span>
                    </div>
                    <div class="summary-row" style="margin-top:12px;">
                        <span>Total a pagar</span>
                        <span class="summary-total">S/ <?php echo e(number_format($monto, 2)); ?></span>
                    </div>
                </div>

                <div class="summary-safe">
                    <span>🔒</span>
                    Pago 100% seguro y monitoreado
                </div>
            </aside>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.method-card');
            const walletSections = document.querySelectorAll('.wallet-section');
            const cardSection = document.querySelector('.card-section');

            const toggleSections = (method) => {
                cards.forEach(card => {
                    const active = card.dataset.metodo === method;
                    card.classList.toggle('active', active);
                    const input = card.querySelector('input[type="radio"]');
                    if (input) input.checked = active;
                });

                walletSections.forEach(section => {
                    const isActive = section.dataset.wallet === method;
                    section.classList.toggle('hidden', !isActive);
                    section.querySelectorAll('input').forEach(input => input.disabled = !isActive);
                });

                if (cardSection) {
                    const active = method === 'tarjeta';
                    cardSection.classList.toggle('hidden', !active);
                    cardSection.querySelectorAll('input').forEach(input => input.disabled = !active);
                }
            };

            cards.forEach(card => card.addEventListener('click', () => toggleSections(card.dataset.metodo)));

            toggleSections(document.querySelector('input[name="metodo"]:checked')?.value || 'yape');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillnest-backend\resources\views/payments/pay.blade.php ENDPATH**/ ?>
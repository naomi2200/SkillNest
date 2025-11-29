<?php
    $cover = $course->image_url
        ? (\Illuminate\Support\Str::startsWith($course->image_url, ['http://', 'https://'])
            ? $course->image_url
            : asset($course->image_url))
        : null;
    $defaultMethod = old('payment_method', 'tarjeta');
?>

<?php $__env->startPush('styles'); ?>
<style>
    .checkout-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 32px;
        padding: 56px 32px 80px;
        margin-top: -16px;
    }

    .checkout-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.8fr);
        gap: 32px;
    }

    .checkout-payment,
    .checkout-summary {
        background: #fff;
        border-radius: 32px;
        padding: 40px;
        box-shadow: 0 40px 120px rgba(0, 0, 0, 0.18);
    }

    .checkout-summary {
        position: sticky;
        top: 120px;
        height: fit-content;
    }

    .checkout-section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }

    .checkout-section-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 32px;
    }

    .checkout-progress {
        position: relative;
        display: flex;
        margin-bottom: 36px;
        gap: 16px;
    }

    .checkout-progress-line {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        height: 3px;
        background: #e5e7eb;
    }

    .checkout-progress-fill {
        height: 100%;
        width: 50%;
        background: linear-gradient(90deg, var(--color-primary), #8b5cf6);
    }

    .checkout-step {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .checkout-step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e5e7eb;
        color: #9ca3af;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .checkout-step.active .checkout-step-circle {
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        color: #fff;
        box-shadow: 0 8px 20px rgba(108, 71, 255, 0.4);
    }

    .checkout-step.completed .checkout-step-circle {
        background: #10b981;
        color: #fff;
    }

    .checkout-step-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #9ca3af;
    }

    .checkout-step.active .checkout-step-label {
        color: var(--color-primary);
    }

    .checkout-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .checkout-method-card {
        border: 2px solid #e5e7eb;
        border-radius: 24px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        background: #fafbff;
        transition: all 0.3s ease;
    }

    .checkout-method-card input {
        display: none;
    }

    .checkout-method-card:hover {
        border-color: var(--color-primary);
        box-shadow: 0 12px 30px rgba(108,71,255,0.15);
        transform: translateY(-2px);
    }

    .checkout-method-card.active {
        border-color: var(--color-primary);
        background: linear-gradient(135deg, rgba(108,71,255,0.08), rgba(139,92,246,0.08));
        box-shadow: 0 12px 30px rgba(108,71,255,0.2);
    }

    .checkout-method-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        color: #fff;
        font-size: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkout-method-card[data-method="tarjeta"] .checkout-method-icon {
        background: linear-gradient(135deg, #8b5cf6, #6c47ff);
    }

    .checkout-method-name {
        font-weight: 700;
        color: #1f2937;
    }

    .checkout-method-desc {
        font-size: 0.85rem;
        color: #6b7280;
        text-align: center;
    }

    .checkout-form-section {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .checkout-form-section.active {
        display: block;
    }

    .checkout-yape-card {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border-radius: 24px;
        padding: 32px;
        border: 2px dashed #a78bfa;
        text-align: center;
    }

    .checkout-yape-qr {
        width: 220px;
        height: 220px;
        margin: 0 auto 20px;
        background: #fff;
        border-radius: 20px;
        padding: 16px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }

    .checkout-yape-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #7c3aed;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .checkout-yape-text {
        color: #6b7280;
        line-height: 1.6;
    }

    .checkout-field {
        margin-top: 24px;
    }

    .checkout-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    .checkout-input {
        width: 100%;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 14px 16px;
        font-size: 0.95rem;
        background: #f9fafb;
        transition: all 0.3s ease;
    }

    .checkout-input:focus {
        outline: none;
        border-color: var(--color-primary);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(108,71,255,0.12);
    }

    .checkout-input-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
    }

    .checkout-submit {
        width: 100%;
        margin-top: 32px;
        padding: 18px;
        border: none;
        border-radius: 18px;
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        color: #fff;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 15px 40px rgba(108,71,255,0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .checkout-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(108,71,255,0.45);
    }

    .summary-course {
        display: flex;
        gap: 16px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 24px;
        margin-bottom: 24px;
    }

    .summary-thumbnail {
        width: 96px;
        height: 72px;
        border-radius: 16px;
        overflow: hidden;
        flex-shrink: 0;
        background: #eef2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-weight: 600;
    }

    .summary-price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 14px;
        font-size: 0.95rem;
    }

    .summary-price-row.total {
        margin-top: 10px;
        padding-top: 14px;
        border-top: 2px solid #e5e7eb;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .summary-total-value {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--color-primary), #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .summary-security {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1));
        border: 1px solid rgba(16,185,129,0.2);
        color: #047857;
        font-size: 0.85rem;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .checkout-wrapper {
            grid-template-columns: 1fr;
        }

        .checkout-summary {
            position: static;
        }
    }
@keyframes fadeIn {
    from {opacity:0; transform: translateY(10px);}
    to {opacity:1; transform: translateY(0);}
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="checkout-page">
        <div class="checkout-wrapper">
            <section class="checkout-payment">
                <header>
                    <h1 class="checkout-section-title">Finalizar compra</h1>
                    <p class="checkout-section-subtitle">Completa tu pago de forma segura</p>
                </header>

                <div class="checkout-progress">
                    <div class="checkout-progress-line">
                        <div class="checkout-progress-fill"></div>
                    </div>
                    <div class="checkout-step completed">
                        <div class="checkout-step-circle">&#10003;</div>
                        <span class="checkout-step-label">Curso</span>
                    </div>
                    <div class="checkout-step active">
                        <div class="checkout-step-circle">2</div>
                        <span class="checkout-step-label">Pago</span>
                    </div>
                    <div class="checkout-step">
                        <div class="checkout-step-circle">3</div>
                        <span class="checkout-step-label">Confirmaci&#243;n</span>
                    </div>
                </div>

                <form action="<?php echo e(route('courses.purchase', $course)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount" value="<?php echo e($course->price); ?>">

                    <div class="checkout-methods">
                        <?php $__currentLoopData = ['yape' => ['icon' => '&#128241;', 'label' => 'Yape', 'desc' => 'Pago instant&#225;neo'],
                                   'tarjeta' => ['icon' => '&#128179;', 'label' => 'Tarjeta', 'desc' => 'D&#233;bito o cr&#233;dito']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="checkout-method-card <?php echo e($defaultMethod === $method ? 'active' : ''); ?>" data-method="<?php echo e($method); ?>">
                                <input type="radio" name="payment_method" value="<?php echo e($method); ?>" <?php echo e($defaultMethod === $method ? 'checked' : ''); ?>>
                                <div class="checkout-method-icon"><?php echo e($info['icon']); ?></div>
                                <span class="checkout-method-name"><?php echo e($info['label']); ?></span>
                                <span class="checkout-method-desc"><?php echo e($info['desc']); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="checkout-form-section checkout-yape-form <?php echo e($defaultMethod === 'yape' ? 'active' : ''); ?>">
                        <div class="checkout-yape-card">
                            <div class="checkout-yape-qr">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR pago">
                            </div>
                            <div class="checkout-yape-number">923 456 789</div>
                            <p class="checkout-yape-text">
                                1. Escanea el c&#243;digo o haz el pago al n&#250;mero indicado<br>
                                2. Monto exacto: <strong>S/ <?php echo e(number_format($course->price, 2)); ?></strong><br>
                                3. Ingresa el c&#243;digo o referencia de tu operaci&#243;n
                            </p>
                            <div class="checkout-field">
                                <label class="checkout-label">Referencia de pago</label>
                                <input type="text" name="reference" value="<?php echo e(old('reference')); ?>" class="checkout-input" placeholder="Ingresa tu c&#243;digo de operaci&#243;n">
                            </div>
                        </div>
                    </div>

                    <div class="checkout-form-section checkout-card-form <?php echo e($defaultMethod === 'tarjeta' ? 'active' : ''); ?>">
                        <div class="checkout-field">
                            <label class="checkout-label">N&#250;mero de tarjeta</label>
                            <input type="text" name="card_number" value="<?php echo e(old('card_number')); ?>" class="checkout-input" maxlength="16" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="checkout-field">
                            <label class="checkout-label">Nombre del titular</label>
                            <input type="text" name="card_name" value="<?php echo e(old('card_name', auth()->user()->name)); ?>" class="checkout-input" placeholder="Como aparece en la tarjeta">
                        </div>
                        <div class="checkout-input-row">
                            <div class="checkout-field">
                                <label class="checkout-label">Fecha de vencimiento</label>
                                <input type="text" class="checkout-input" placeholder="MM/AA" maxlength="5">
                            </div>
                            <div class="checkout-field">
                                <label class="checkout-label">CVV</label>
                                <input type="text" class="checkout-input" placeholder="123" maxlength="3">
                            </div>
                        </div>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600" style="margin-top:24px;">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <button type="submit" class="checkout-submit">Confirmar pago</button>
                </form>
            </section>

            <aside class="checkout-summary">
                <h2 class="checkout-section-title" style="font-size:1.5rem;margin-bottom:24px;">Resumen del pedido</h2>
                <div class="summary-course">
                    <div class="summary-thumbnail">
                        <?php if($cover): ?>
                            <img src="<?php echo e($cover); ?>" alt="Miniatura del curso" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            <?php echo e(strtoupper(substr($course->title,0,2))); ?>

                        <?php endif; ?>
                    </div>
                    <div>
                        <h3 style="margin:0 0 6px; font-size:1rem; font-weight:700;"><?php echo e($course->title); ?></h3>
                        <p style="margin:0; color:#6b7280; font-size:0.9rem;">
                            <?php echo e($course->duration); ?> horas &#8226; <?php echo e($course->category ?? 'Curso'); ?>

                        </p>
                    </div>
                </div>

                <div>
                    <div class="summary-price-row">
                        <span class="price-label">Precio del curso</span>
                        <span class="price-value">S/ <?php echo e(number_format($course->price, 2)); ?></span>
                    </div>
                    <div class="summary-price-row">
                        <span class="price-label">Descuento</span>
                        <span class="price-value" style="color:#10b981;">- S/ 0.00</span>
                    </div>
                    <div class="summary-price-row total">
                        <span>Total</span>
                        <span class="summary-total-value">S/ <?php echo e(number_format($course->price, 2)); ?></span>
                    </div>
                </div>

                <div class="summary-security">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Pago 100% seguro y encriptado
                </div>
            </aside>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const methodCards = document.querySelectorAll('.checkout-method-card');
            const yapeSection = document.querySelector('.checkout-yape-form');
            const cardSection = document.querySelector('.checkout-card-form');

            const toggleSections = (method) => {
                methodCards.forEach(card => {
                    const active = card.dataset.method === method;
                    card.classList.toggle('active', active);
                    const input = card.querySelector('input[type="radio"]');
                    if (input) input.checked = active;
                });

                yapeSection.classList.toggle('active', method === 'yape');
                cardSection.classList.toggle('active', method === 'tarjeta');
            };

            methodCards.forEach(card => {
                card.addEventListener('click', () => toggleSections(card.dataset.method));
            });

            toggleSections(document.querySelector('input[name="payment_method"]:checked')?.value || 'tarjeta');
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PHP\SkillNest\skillNest\resources\views/courses/checkout.blade.php ENDPATH**/ ?>
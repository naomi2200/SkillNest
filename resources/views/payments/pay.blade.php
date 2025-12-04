@extends('layouts.dashboard')

@php
    $defaultMetodo = old('metodo', 'yape');
    $metodoEsTarjeta = $defaultMetodo === 'tarjeta';
@endphp

@push('styles')
<style>
    .checkout-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 32px;
        padding: 40px 32px 64px;
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
    }

    .checkout-section-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
        margin-bottom: 32px;
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

    .checkout-wallet-card {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border-radius: 24px;
        padding: 32px;
        border: 2px dashed #a78bfa;
        text-align: center;
    }

    .checkout-wallet-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #7c3aed;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .checkout-wallet-text {
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

    .checkout-file-button {
        width: 100%;
        padding: 16px;
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        background: #fff;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        justify-content: center;
        gap: 10px;
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
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 24px;
        margin-bottom: 24px;
    }

    .summary-course h3 {
        margin: 0 0 6px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .summary-course p {
        margin: 0;
        color: #6b7280;
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
        margin-top: 24px;
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
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
@endpush

@section('dashboard-content')
    <div class="checkout-page">
        <div class="checkout-wrapper">
            <section class="checkout-payment">
                <header>
                    <h1 class="checkout-section-title">Pagar mentor&#237;a</h1>
                    <p class="checkout-section-subtitle">Completa tu pago para confirmar la sesi&#243;n</p>
                </header>

                @php
                    $walletMethods = [
                        'yape' => ['icon' => '&#128241;', 'label' => 'Yape', 'desc' => 'Pago instant&#225;neo', 'number' => '923 456 789'],
                        'plin' => ['icon' => '&#128242;', 'label' => 'Plin', 'desc' => 'Transferencia inmediata', 'number' => '987 654 321'],
                        'tarjeta' => ['icon' => '&#128179;', 'label' => 'Tarjeta', 'desc' => 'D&#233;bito o cr&#233;dito']
                    ];
                @endphp

                <form method="POST"
                      action="{{ route('mentorias.payment.store', $mentoria->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="checkout-methods">
                        @foreach ($walletMethods as $method => $info)
                            <label class="checkout-method-card {{ $defaultMetodo === $method ? 'active' : '' }}" data-metodo="{{ $method }}">
                                <input type="radio" name="metodo" value="{{ $method }}" {{ $defaultMetodo === $method ? 'checked' : '' }}>
                                <div class="checkout-method-icon">{{ $info['icon'] }}</div>
                                <span class="checkout-method-name">{{ $info['label'] }}</span>
                                <span class="checkout-method-desc">{{ $info['desc'] }}</span>
                            </label>
                        @endforeach
                    </div>

                    @foreach (['yape', 'plin'] as $wallet)
                        <div class="checkout-form-section checkout-wallet-form {{ $defaultMetodo === $wallet ? 'active' : '' }}" data-wallet="{{ $wallet }}">
                            <div class="checkout-wallet-card">
                                <div class="checkout-wallet-number">{{ $walletMethods[$wallet]['number'] }}</div>
                                <p class="checkout-wallet-text">
                                    1. Realiza el pago a este n&#250;mero usando {{ ucfirst($wallet) }}<br>
                                    2. Monto exacto: <strong>S/ {{ number_format($monto, 2) }}</strong><br>
                                    3. Adjunta tu comprobante para validar la operaci&#243;n
                                </p>
                                <div class="checkout-field">
                                    <label class="checkout-label">Comprobante de pago</label>
                                    <input type="file" name="comprobante" id="comprobante-{{ $wallet }}" class="checkout-input" style="display:none;" accept="image/*">
                                    <label class="checkout-file-button" for="comprobante-{{ $wallet }}">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                        Subir comprobante
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="checkout-form-section checkout-card-form {{ $metodoEsTarjeta ? 'active' : '' }}">
                        <div class="checkout-field">
                            <label class="checkout-label">N&#250;mero de tarjeta</label>
                            <input type="text" name="numero_tarjeta" value="{{ old('numero_tarjeta') }}" class="checkout-input" maxlength="16" placeholder="0000 0000 0000 0000">
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600" style="margin-top:24px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <button class="checkout-submit">Confirmar pago</button>
                </form>
            </section>

            <aside class="checkout-summary">
                <h2 class="checkout-section-title" style="font-size:1.5rem;margin-bottom:24px;">Resumen</h2>
                <div class="summary-course">
                    <h3>{{ $mentoria->mentor->name ?? 'Mentor SkillNest' }}</h3>
                    <p>{{ $mentoria->especialidad ?? 'Mentor&#237;a personalizada' }}</p>
                </div>

                <div>
                    <div class="summary-price-row">
                        <span class="price-label">Monto de la mentor&#237;a</span>
                        <span class="price-value">S/ {{ number_format($monto, 2) }}</span>
                    </div>
                    <div class="summary-price-row">
                        <span class="price-label">Comisi&#243;n</span>
                        <span class="price-value">S/ 0.00</span>
                    </div>
                    <div class="summary-price-row total">
                        <span>Total a pagar</span>
                        <span class="summary-total-value">S/ {{ number_format($monto, 2) }}</span>
                    </div>
                </div>

                <div class="summary-security">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Pago 100% seguro y monitoreado
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.checkout-method-card');
        const walletSections = document.querySelectorAll('.checkout-wallet-form');
        const cardSection = document.querySelector('.checkout-card-form');

        const toggleSections = (method) => {
            cards.forEach(card => {
                const active = card.dataset.metodo === method;
                card.classList.toggle('active', active);
                const input = card.querySelector('input[type="radio"]');
                if (input) input.checked = active;
            });

            walletSections.forEach(section => {
                const isActive = section.dataset.wallet === method;
                section.classList.toggle('active', isActive);
                section.querySelectorAll('input').forEach(input => input.disabled = !isActive);
            });

            if (cardSection) {
                const active = method === 'tarjeta';
                cardSection.classList.toggle('active', active);
                cardSection.querySelectorAll('input').forEach(input => input.disabled = !active);
            }
        };

        cards.forEach(card => card.addEventListener('click', () => toggleSections(card.dataset.metodo)));

        toggleSections(document.querySelector('input[name="metodo"]:checked')?.value || 'yape');
    });
</script>
@endpush

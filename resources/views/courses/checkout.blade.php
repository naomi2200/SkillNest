@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-4xl space-y-8 py-10">
        <div class="rounded-3xl bg-white p-8 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-400">Proceso de pago</p>
                    <h1 class="text-3xl font-bold text-secondary">Completa tu compra</h1>
                    <p class="text-sm text-slate-500">Curso seleccionado: <span class="font-semibold">{{ $course->title }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-400">Precio</p>
                    <p class="text-3xl font-bold text-primary">S/ {{ number_format($course->price, 2) }}</p>
                </div>
            </div>

            <form action="{{ route('courses.purchase', $course) }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <input type="hidden" name="amount" value="{{ $course->price }}">

                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-secondary">Método de pago</p>
                    <div class="grid gap-3 sm:grid-cols-3">
                        @foreach(['tarjeta' => 'Tarjeta', 'yape' => 'Yape', 'plin' => 'Plin'] as $method => $label)
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border p-3 text-sm font-semibold text-slate-600 hover:border-primary">
                                <input type="radio" name="payment_method" value="{{ $method }}" class="text-primary focus:ring-primary" {{ old('payment_method', 'tarjeta') === $method ? 'checked' : '' }}>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div id="card-fields" class="space-y-4">
                    <label class="block text-sm font-semibold text-secondary">
                        Nombre del titular
                        <input type="text" name="card_name" value="{{ old('card_name', auth()->user()->name) }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                    </label>
                    <label class="block text-sm font-semibold text-secondary">
                        Número de tarjeta
                        <input type="text" name="card_number" value="{{ old('card_number') }}" maxlength="16" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" placeholder="0000 0000 0000 0000">
                    </label>
                </div>

                <div id="wallet-fields" class="hidden space-y-4">
                    <label class="block text-sm font-semibold text-secondary">
                        Referencia o código de operación
                        <input type="text" name="reference" value="{{ old('reference') }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" placeholder="Ingrese el código de pago">
                    </label>
                </div>

                @if($errors->any())
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
                        {{ $errors->first() }}
                    </div>
                @endif

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
@endsection

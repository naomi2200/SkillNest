@extends('layouts.app')

@php
    $cover = $course->image_url
        ? (\Illuminate\Support\Str::startsWith($course->image_url, ['http://', 'https://'])
            ? $course->image_url
            : asset($course->image_url))
        : null;
    $defaultMethod = old('payment_method', 'tarjeta');
@endphp

@section('content')
<div class="mx-auto max-w-6xl px-4 py-16">
    <div class="space-y-6">
        <header class="text-center space-y-2">
            <p class="text-xs uppercase tracking-[0.4em] text-purple-600">Compra segura</p>
            <h1 class="text-3xl font-semibold text-gray-900">Finalizar compra</h1>
            <p class="text-sm text-gray-500 max-w-2xl mx-auto">Completa tu pago de forma segura y accede al contenido premium de inmediato.</p>
        </header>

        <div class="grid gap-8 lg:grid-cols-[1.25fr,0.75fr]">
            <section x-data="{ method: '{{ $defaultMethod }}' }" class="space-y-6 rounded-[32px] bg-white shadow-[0_35px_90px_rgba(15,23,42,0.12)] p-8">
                <div class="space-y-3">
                    <p class="text-sm uppercase tracking-[0.3em] text-gray-500">Paso 2 · Pago</p>
                    <h2 class="text-2xl font-bold text-gray-900">Datos de pago</h2>
                    <p class="text-sm text-gray-500">Ingresa los datos para cerrar la compra del curso seleccionado.</p>
                </div>

                <div class="grid grid-cols-3 gap-4 text-center text-xs font-semibold uppercase tracking-[0.4em] text-gray-500">
                    <div class="space-y-1">
                        <div class="mx-auto h-10 w-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">1</div>
                        <p>Curso</p>
                    </div>
                    <div class="space-y-1">
                        <div class="mx-auto h-10 w-10 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 text-white flex items-center justify-center">2</div>
                        <p>Pago</p>
                    </div>
                    <div class="space-y-1">
                        <div class="mx-auto h-10 w-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center">3</div>
                        <p>Confirmación</p>
                    </div>
                </div>

                <form action="{{ route('courses.purchase', $course) }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $course->price }}">
                    <input type="hidden" name="payment_method" x-model="method">

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="relative cursor-pointer rounded-2xl border p-5 text-center transition" :class="method === 'yape' ? 'border-purple-500 bg-white shadow-lg' : 'border border-gray-200 bg-white/70'">
                            <input type="radio" class="sr-only" name="payment_method" value="yape" x-model="method">
                            <div class="flex flex-col items-center gap-2">
                                <div class="h-12 w-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl">&#128241;</div>
                                <div class="text-base font-semibold text-gray-800">Yape</div>
                                <p class="text-xs text-gray-500">Pago instantáneo</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer rounded-2xl border p-5 text-center transition" :class="method === 'tarjeta' ? 'border-purple-500 bg-white shadow-lg' : 'border border-gray-200 bg-white/70'">
                            <input type="radio" class="sr-only" name="payment_method" value="tarjeta" x-model="method">
                            <div class="flex flex-col items-center gap-2">
                                <div class="h-12 w-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">&#128179;</div>
                                <div class="text-base font-semibold text-gray-800">Tarjeta</div>
                                <p class="text-xs text-gray-500">Débito o crédito</p>
                            </div>
                        </label>
                    </div>

                    <div x-show="method === 'yape'" style="display:none;" class="space-y-4 rounded-2xl border border-dashed border-purple-200 bg-purple-50/80 p-6 text-sm text-purple-700">
                        <div class="flex flex-col items-center gap-3">
                            <div class="h-32 w-32 rounded-2xl bg-white p-3 shadow">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR pago" class="h-full w-full object-cover">
                            </div>
                            <p class="text-base font-semibold">Número: 923 456 789</p>
                        </div>
                        <p class="text-xs text-purple-700/80 leading-relaxed">
                            1. Escanea el código o haz la transferencia<br>
                            2. Monto exacto: <strong>S/ {{ number_format($course->price, 2) }}</strong><br>
                            3. Ingresa la referencia en el campo inferior
                        </p>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-purple-600">Referencia de pago</label>
                            <input name="reference" value="{{ old('reference') }}" class="w-full rounded-2xl border border-purple-200 bg-white px-4 py-3 text-sm text-purple-700 focus:border-purple-500 focus:outline-none" placeholder="Código de operación">
                        </div>
                    </div>

                    <div x-show="method === 'tarjeta'" style="display:none;" class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-gray-500">Número de tarjeta</label>
                            <input name="card_number" value="{{ old('card_number') }}" maxlength="16" class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-700 focus:border-purple-500 focus:outline-none" placeholder="0000 0000 0000 0000">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-gray-500">Nombre del titular</label>
                            <input name="card_name" value="{{ old('card_name', auth()->user()->name ?? '') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-700 focus:border-purple-500 focus:outline-none" placeholder="Como aparece en la tarjeta">
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-500">Vencimiento (MM/AA)</label>
                                <input type="text" maxlength="5" class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-700 focus:border-purple-500 focus:outline-none" placeholder="MM/AA">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-500">CVV</label>
                                <input type="text" maxlength="3" class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-700 focus:border-purple-500 focus:outline-none" placeholder="123">
                            </div>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <button type="submit" class="w-full rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-600 px-6 py-4 text-lg font-semibold text-white shadow-lg shadow-purple-300 transition hover:opacity-95">
                        Confirmar pago
                    </button>
                </form>
            </section>

            <aside class="space-y-6 rounded-[32px] border border-gray-100 bg-white p-6 shadow-2xl">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-50 text-xl font-bold text-gray-700">
                        @if ($cover)
                            <img src="{{ $cover }}" alt="Miniatura del curso" class="h-full w-full rounded-xl object-cover">
                        @else
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($course->title, 0, 2)) }}
                        @endif
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Curso</p>
                        <h3 class="text-xl font-semibold text-gray-900">{{ $course->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $course->category ?? $course->categoria ?? 'Curso' }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Duración</span>
                        <span>{{ $course->duration ?? $course->duracion ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Modalidad</span>
                        <span>{{ $course->modalidad ?? 'Virtual' }}</span>
                    </div>
                </div>
                <div class="space-y-2 border-t border-gray-100 pt-4">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Precio del curso</span>
                        <span>S/ {{ number_format($course->price, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Descuento</span>
                        <span class="text-emerald-500">- S/ 0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold text-gray-900">
                        <span>Total</span>
                        <span>S/ {{ number_format($course->price, 2) }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    Pago 100% seguro y encriptado
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection

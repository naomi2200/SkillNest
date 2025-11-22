@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <header class="rounded-[40px] border border-slate-100 bg-gradient-to-r from-white via-slate-50 to-white px-6 py-6 text-secondary shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.5em] text-slate-400">Hola, {{ auth()->user()->name }}</p>
                    <h1 class="text-3xl font-semibold">@yield('dashboard-title', 'Panel')</h1>
                    <p class="text-sm text-slate-500">@yield('dashboard-subtitle', 'Explora y gestiona todo tu ecosistema SkillNest')</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @yield('dashboard-actions')
                </div>
            </div>
        </header>

        @hasSection('dashboard-widgets')
            <section class="grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
                @yield('dashboard-widgets')
            </section>
        @endif

        <section class="space-y-6">
            @yield('dashboard-content')
        </section>
    </div>
@endsection

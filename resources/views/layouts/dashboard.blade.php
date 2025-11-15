@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <header class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-slate-400">Hola, {{ auth()->user()->name }}</p>
                <h1 class="text-2xl font-bold text-secondary">@yield('dashboard-title', 'Dashboard')</h1>
            </div>
            @yield('dashboard-actions')
        </header>

        @hasSection('dashboard-widgets')
            <section class="grid gap-6 lg:grid-cols-2">
                @yield('dashboard-widgets')
            </section>
        @endif

        <section>
            @yield('dashboard-content')
        </section>
    </div>
@endsection

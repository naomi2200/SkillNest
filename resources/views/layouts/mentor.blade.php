@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <header class="rounded-[32px] border border-slate-100 bg-white/90 px-8 py-6 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Panel mentor</p>
                    <h1 class="text-3xl font-semibold text-secondary">@yield('mentor-title', 'Mi panel de mentor')</h1>
                    <p class="text-sm text-slate-500">@yield('mentor-subtitle', 'Gestiona tus cursos y mentorías')</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @yield('mentor-actions')
                </div>
            </div>
        </header>

        <main class="space-y-6">
            @yield('mentor-content')
        </main>
    </div>
@endsection


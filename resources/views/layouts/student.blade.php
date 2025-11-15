@extends('layouts.app')

@php
    $studentUser = auth()->user();
@endphp

@section('app-sidebar')
    <aside class="hidden w-64 flex-shrink-0 border-r border-transparent bg-transparent lg:block">
        <div class="sticky top-24 rounded-3xl border border-slate-100 bg-white/90 p-5 shadow-card">
            <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Estudiante</p>
            <h2 class="mt-1 text-lg font-semibold text-secondary">Mi panel</h2>

            <nav class="mt-6 space-y-2 text-sm font-medium text-slate-500">
                <a href="{{ route('student.dashboard') }}"
                   class="flex items-center justify-between rounded-2xl px-4 py-2 transition {{ request()->routeIs('student.dashboard') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                    <span>Inicio</span>
                    <span class="text-[10px] uppercase tracking-wide">Home</span>
                </a>
                <a href="{{ route('student.courses') }}"
                   class="flex items-center justify-between rounded-2xl px-4 py-2 transition {{ request()->routeIs('student.courses') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                    <span>Mis cursos</span>
                    <span class="text-[10px] uppercase tracking-wide">Cursos</span>
                </a>
                <a href="{{ route('student.mentorias') }}"
                   class="flex items-center justify-between rounded-2xl px-4 py-2 transition {{ request()->routeIs('student.mentorias') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                    <span>Mis mentorías</span>
                    <span class="text-[10px] uppercase tracking-wide">Sesiones</span>
                </a>
                <a href="{{ route('student.profile') }}"
                   class="flex items-center justify-between rounded-2xl px-4 py-2 transition {{ request()->routeIs('student.profile') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                    <span>Mi perfil</span>
                    <span class="text-[10px] uppercase tracking-wide">Perfil</span>
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('content')
    <div class="space-y-6">
        <header class="rounded-[32px] border border-slate-100 bg-white/90 px-6 py-5 shadow-card">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Hola, {{ $studentUser->name ?? 'estudiante' }}</p>
                    <h1 class="text-2xl font-semibold text-secondary">@yield('student-title', 'Panel del estudiante')</h1>
                    <p class="text-sm text-slate-500">@yield('student-subtitle', 'Revisa tus cursos y mentorías')</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @yield('student-actions')
                </div>
            </div>
        </header>

        @hasSection('student-widgets')
            <section class="grid gap-4 md:grid-cols-2">
                @yield('student-widgets')
            </section>
        @endif

        <section class="space-y-5">
            @yield('student-content')
        </section>
    </div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Administrativo') · SkillNest</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <div class="flex min-h-screen">
        <aside class="hidden w-72 flex-shrink-0 border-r border-slate-200 bg-white/95 px-6 py-8 lg:flex">
            <div class="flex w-full flex-col gap-8">
                <div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-indigo-600">SkillNest</span>
                        <span class="rounded-full bg-indigo-100 px-3 py-0.5 text-xs font-semibold text-indigo-700">Admin</span>
                    </a>
                </div>
                <nav class="space-y-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">General</p>
                        <ul class="mt-3 space-y-1 text-sm">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700 {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                                    </svg>
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.courses.index') }}"
                                   class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700 {{ request()->routeIs('admin.courses.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 11h14M7 15h10M9 19h6"/>
                                    </svg>
                                    Cursos
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-4.215A2 2 0 0016.683 11H7.317a2 2 0 00-1.912 1.785L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    Mentorías
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Gestión</p>
                        <ul class="mt-3 space-y-1 text-sm">
                            <li>
                                <a href="#"
                                   class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Usuarios
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-slate-600 transition hover:bg-indigo-50 hover:text-indigo-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v2a1 1 0 001 1h4a1 1 0 001-1v-2m-6-4h8M5 11h14M7 7h10"/>
                                    </svg>
                                    Reportes
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="mt-auto rounded-2xl border border-slate-200 bg-slate-50/80 p-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Estado</p>
                    <p class="mt-2 text-sm text-slate-600">Sistema estable · Última sincronización hace 5 min.</p>
                </div>
            </div>
        </aside>
        <div class="flex w-full flex-1 flex-col">
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/80 backdrop-blur">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Panel administrativo</p>
                        <h1 class="text-2xl font-bold text-secondary">@yield('title', 'SkillNest Admin')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name ?? 'Administrador' }}</p>
                            <p class="text-xs text-slate-400">{{ auth()->user()->email ?? 'admin@skillnest.com' }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-indigo-100 text-center text-lg font-semibold text-indigo-700 leading-[3rem]">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 px-6 py-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

@php
    $sidebarUser = auth()->user();
@endphp

@if($sidebarUser?->isMentor())
    <aside class="hidden w-64 flex-shrink-0 bg-slate-50 lg:block">
        <div class="h-full space-y-4 p-4">
            <div class="rounded-3xl bg-white p-5 shadow-card">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Mentor</p>
                <h2 class="mt-2 text-lg font-semibold text-secondary">Panel de Mentor</h2>

                <nav class="mt-5 space-y-2 text-sm font-medium text-slate-500">
                    <a href="{{ route('mentor.courses') }}"
                       class="flex items-center gap-3 rounded-2xl px-3 py-2 transition {{ request()->routeIs('mentor.courses') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                        Mis cursos
                    </a>
                    <a href="{{ route('mentor.courses.create') }}"
                       class="flex items-center gap-3 rounded-2xl px-3 py-2 transition {{ request()->routeIs('mentor.courses.create') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                        Crear curso
                    </a>
                    <a href="{{ route('mentor.mentorias.index') }}"
                       class="flex items-center gap-3 rounded-2xl px-3 py-2 transition {{ request()->routeIs('mentor.mentorias.*') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                        Mis mentorías
                    </a>
                    <a href="{{ route('mentorias.create') }}"
                       class="flex items-center gap-3 rounded-2xl px-3 py-2 transition {{ request()->routeIs('mentorias.create') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                        Crear mentoría
                    </a>
                    <a href="{{ route('mentor.profile') }}"
                       class="flex items-center gap-3 rounded-2xl px-3 py-2 transition {{ request()->routeIs('mentor.profile') ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100' }}">
                        Mi perfil
                    </a>
                </nav>
            </div>
        </div>
    </aside>
@elseif($sidebarUser)
    <aside class="hidden w-64 flex-shrink-0 border-r bg-white lg:block">
        <div class="h-full space-y-6 px-4 py-6">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-400">General</p>
                <ul class="mt-3 space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:bg-slate-100' }}">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cursos.index') }}"
                           class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('cursos.*') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:bg-slate-100' }}">
                            Cursos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mentor-market.index') }}"
                           class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('mentor-market.*') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:bg-slate-100' }}">
                            Mentorías
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
@endif


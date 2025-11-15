<header class="sticky top-0 z-50 border-b bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-20 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-secondary">
            <svg class="h-9 w-9 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 7h16M4 12h10m-6 5h12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            SkillNest
        </a>

        <nav class="hidden flex-1 justify-center gap-8 text-sm font-semibold text-slate-500 lg:flex">
            <a href="{{ route('cursos.index') }}" class="{{ request()->routeIs('cursos.*') ? 'text-secondary' : 'hover:text-secondary' }}">Cursos</a>
            <a href="{{ route('mentor-market.index') }}" class="{{ request()->routeIs('mentor-market.*') ? 'text-secondary' : 'hover:text-secondary' }}">Mentorías</a>
            <a href="{{ route('mentor.students') }}" class="{{ request()->routeIs('mentor.*') ? 'text-secondary' : 'hover:text-secondary' }}">Conviértete en Mentor</a>
        </nav>

        @php
            $webUser = auth()->user();
            $adminUser = auth('admin')->user();
        @endphp

        <div class="flex items-center gap-3">
            @if($webUser)
                @php
                    $panelRoute = $webUser->isMentor()
                        ? route('mentor.courses')
                        : ($webUser->isStudent() ? route('student.dashboard') : route('dashboard'));
                @endphp
                <a href="{{ $panelRoute }}" class="btn-secondary rounded-full px-5">Panel</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-gradient">Salir</button>
                </form>
            @elseif($adminUser)
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary rounded-full px-5">Panel admin</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn-gradient">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-secondary rounded-full px-5">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn-gradient">Registrarse</a>
            @endif
        </div>
    </div>
</header>





@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-12">
        <section class="rounded-[32px] bg-gradient-to-br from-primary to-secondary p-10 text-white shadow-card">
            <p class="text-sm uppercase tracking-wide text-white/70">Plataforma educativa</p>
            <h1 class="mt-4 text-4xl font-bold leading-tight">Aprende y enseña con SkillNest</h1>
            <p class="mt-4 max-w-2xl text-base text-white/80">
                Cursos estructurados, mentorías 1 a 1 y dashboards claros para estudiantes y mentores. Todo construido con Laravel 11 y Tailwind CSS.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="btn-primary bg-white text-secondary hover:bg-slate-100">Comienza ahora</a>
                <a href="{{ route('cursos.index') }}" class="btn-secondary border-white/50 text-white hover:bg-white/10">Explorar cursos</a>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-3">
            <article class="card">
                <p class="text-sm font-semibold text-primary">Estudiantes</p>
                <h2 class="mt-3 text-xl font-semibold text-secondary">Dashboard personal</h2>
                <p class="mt-2 text-sm text-slate-500">Revisa tus cursos inscritos, progreso y mentorías agendadas.</p>
            </article>
            <article class="card">
                <p class="text-sm font-semibold text-primary">Mentores</p>
                <h2 class="mt-3 text-xl font-semibold text-secondary">Gestión completa</h2>
                <p class="mt-2 text-sm text-slate-500">Crea cursos, administra estudiantes y controla tus mentorías.</p>
            </article>
            <article class="card">
                <p class="text-sm font-semibold text-primary">Notificaciones</p>
                <h2 class="mt-3 text-xl font-semibold text-secondary">En tiempo real</h2>
                <p class="mt-2 text-sm text-slate-500">Recibe alertas por inscripciones, confirmaciones y recordatorios.</p>
            </article>
        </section>
    </div>
@endsection

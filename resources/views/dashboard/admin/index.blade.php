@extends('layouts.dashboard')

@section('dashboard-title', 'Panel administrativo')

@section('dashboard-content')
    <div class="grid gap-6 md:grid-cols-3">
        <div class="card">
            <p class="text-sm text-slate-500">Cursos activos</p>
            <p class="text-3xl font-bold text-secondary">{{ $stats['courses_active'] ?? 0 }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-slate-500">Ventas registradas</p>
            <p class="text-3xl font-bold text-secondary">S/ {{ number_format($stats['total_sales'] ?? 0, 2) }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-slate-500">Inscritos</p>
            <p class="text-3xl font-bold text-secondary">{{ $stats['total_students'] ?? 0 }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card">
            <h2 class="text-lg font-semibold text-secondary">Cursos pendientes</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @forelse($pendingCourses as $course)
                    <li class="flex items-center justify-between">
                        <span>{{ $course->title }}</span>
                        <a href="{{ route('admin.courses.review') }}" class="text-primary">Revisar</a>
                    </li>
                @empty
                    <li class="text-slate-500">No hay cursos pendientes.</li>
                @endforelse
            </ul>
        </div>
        <div class="card">
            <h2 class="text-lg font-semibold text-secondary">Nuevos usuarios</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @forelse($recentUsers as $user)
                    <li>{{ $user->name }} · {{ ucfirst($user->role) }}</li>
                @empty
                    <li class="text-slate-500">Sin registros recientes.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection

@extends('layouts.mentor')

@section('mentor-title', 'Mis cursos')
@section('mentor-subtitle', 'Gestiona y publica tus experiencias Lovable')

@section('mentor-actions')
    <a href="{{ route('mentor.courses.create') }}" class="btn-gradient rounded-full px-6">Crear curso</a>
@endsection

@section('mentor-content')
    <div class="rounded-3xl border border-slate-100 bg-white shadow-card">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="py-3">Curso</th>
                    <th class="py-3">Inscritos</th>
                    <th class="py-3">Revisión</th>
                    <th class="py-3">Estado</th>
                    <th class="py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($courses as $course)
                    <tr>
                        <td class="py-4">
                            <p class="font-semibold text-secondary">{{ $course->title }}</p>
                            <p class="text-xs text-slate-500">{{ $course->category }} · {{ $course->level }}</p>
                        </td>
                        <td class="py-4 text-slate-600">{{ $course->estudiantes_count ?? 0 }}</td>
                        <td class="py-4">
                            <span class="badge {{ $course->review_status === 'approved' ? 'bg-success/10 text-success' : ($course->review_status === 'pending' ? 'bg-warning/10 text-warning' : 'bg-slate-100 text-slate-500') }}">
                                {{ ucfirst($course->review_status) }}
                            </span>
                        </td>
                        <td class="py-4">
                            <span class="badge {{ $course->status === 'activo' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-500' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        <td class="py-4 text-right space-x-2">
                            <a href="{{ route('mentor.courses.builder', $course) }}" class="text-sm font-semibold text-primary hover:text-primary/80">Editar</a>
                            <a href="{{ route('courses.classroom', $course) }}" class="text-sm text-slate-500 hover:text-secondary">Aula</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-sm text-slate-500">
                            Aún no has creado cursos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

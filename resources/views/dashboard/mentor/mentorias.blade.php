@extends('layouts.mentor')

@section('mentor-title', 'Mis mentorías')
@section('mentor-subtitle', 'Personas inscritas en tus mentorías SkillNest')

@section('mentor-actions')
    <a href="{{ route('mentorias.create') }}" class="btn-gradient rounded-full px-6">Crear mentoría</a>
@endsection

@section('mentor-content')
    {{-- Sección: listado principal de mentorías (Read del CRUD para mentores). --}}
    <div class="rounded-3xl border border-slate-100 bg-white shadow-card">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                <tr>
                    <th class="py-3">Mentoría</th>
                    <th class="py-3">Precio</th>
                    <th class="py-3">Estado</th>
                    <th class="py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($mentorias as $mentoria)
                    <tr>
                        <td class="py-4">
                            <p class="font-semibold text-secondary">{{ $mentoria->titulo }}</p>
                            <p class="text-xs text-slate-500">{{ $mentoria->modalidad === 'virtual' ? 'Virtual' : 'Presencial' }}</p>
                        </td>
                        <td class="py-4 text-slate-600">S/ {{ number_format($mentoria->precio, 2) }}</td>
                        <td class="py-4">
                            <span class="badge {{ $mentoria->estado === 'confirmada' ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning' }}">
                                {{ ucfirst($mentoria->estado) }}
                            </span>
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('mentorias.edit', $mentoria) }}" class="text-sm font-semibold text-primary hover:text-primary/80">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-sm text-slate-500">
                            No has configurado mentorías todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

{{-- Sección: tabla de cursos activos --}}
<div class="dashboard-card space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Gestión de cursos</p>
            <h2 class="text-2xl font-semibold text-secondary">Listado general</h2>
            <p class="text-sm text-slate-500">Consulta cursos publicados, rechazados y en revisión en formato tabla.</p>
        </div>
        <form method="GET" class="flex gap-2">
            <input type="hidden" name="view" value="tabla">
            <select name="status" class="rounded-2xl border border-slate-200 px-3 py-2 text-sm text-slate-600 focus:border-primary focus:outline-none">
                <option value="aprobado" @selected($currentStatus === 'aprobado')>Aprobados</option>
                <option value="pendiente" @selected($currentStatus === 'pendiente')>Pendientes</option>
                <option value="rechazado" @selected($currentStatus === 'rechazado')>Rechazados</option>
            </select>
            <button class="rounded-full bg-secondary px-4 py-2 text-sm font-semibold text-white shadow-card">Filtrar</button>
        </form>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-slate-100 bg-white">
        <table class="min-w-full divide-y divide-slate-100 text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs uppercase tracking-[0.2em] text-slate-400">
            <tr>
                <th class="px-5 py-3 text-left">Curso</th>
                <th class="px-5 py-3 text-left">Mentor</th>
                <th class="px-5 py-3 text-left">Estado</th>
                <th class="px-5 py-3 text-left">Módulos</th>
                <th class="px-5 py-3 text-left">Actualizado</th>
                <th class="px-5 py-3 text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
            @forelse($courses as $course)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-secondary">{{ $course->title }}</p>
                        <p class="text-xs text-slate-400">{{ $course->category }}</p>
                    </td>
                    <td class="px-5 py-4">{{ $course->mentor->name ?? 'Sin asignar' }}</td>
                    <td class="px-5 py-4">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize
                            @class([
                                'bg-amber-100 text-amber-700' => $course->status === 'pendiente',
                                'bg-emerald-100 text-emerald-700' => $course->status === 'aprobado',
                                'bg-rose-100 text-rose-600' => $course->status === 'rechazado',
                            ])">
                            {{ $course->status }}
                        </span>
                    </td>
                    <td class="px-5 py-4">{{ $course->modules_count }}</td>
                    <td class="px-5 py-4 text-xs text-slate-500">{{ optional($course->updated_at)->diffForHumans() ?? 'N/A' }}</td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.courses.show', $course->id) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-secondary">Ver</a>
                            @if($course->status === 'pendiente')
                                <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aprobar</button>
                                </form>
                                <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="rejection_reason" value="Rechazado desde listado">
                                    <button class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-600">Rechazar</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-6 text-center text-sm text-slate-500">No hay registros para el estado seleccionado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

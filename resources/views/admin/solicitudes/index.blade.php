{{-- Vista exclusiva para admins: bandeja de solicitudes --}}
<div class="dashboard-card space-y-6">
    {{-- Sección: tabs de estado --}}
    @php
        $tabs = [
            'pendiente' => 'Pendientes',
            'aprobado' => 'Aprobados',
            'rechazado' => 'Rechazados',
        ];
    @endphp
    <div class="flex flex-wrap gap-3">
        @foreach($tabs as $status => $label)
            <a href="{{ route('admin.courses.index', ['status' => $status, 'view' => 'solicitudes']) }}"
               class="rounded-full px-5 py-2 text-sm font-semibold transition
                    {{ $currentStatus === $status ? 'bg-indigo-600 text-white shadow-card' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Sección: tarjetas de revisión --}}
    <div class="space-y-4">
        @forelse($courses as $course)
            <article class="rounded-[32px] border border-slate-100 bg-slate-50/80 p-6 shadow-inner">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">{{ $course->category }}</p>
                        <h3 class="text-xl font-semibold text-secondary">{{ $course->title }}</h3>
                        <p class="text-sm text-slate-500">Mentor: {{ $course->mentor->name ?? 'Sin asignar' }}</p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize
                        @class([
                            'bg-amber-100 text-amber-700' => $course->status === 'pendiente',
                            'bg-emerald-100 text-emerald-700' => $course->status === 'aprobado',
                            'bg-rose-100 text-rose-600' => $course->status === 'rechazado',
                        ])">
                        {{ $course->status }}
                    </span>
                </div>

                <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 220) }}</p>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                    <span>{{ $course->modules_count }} módulos</span>
                    <span>•</span>
                    <span>Actualizado {{ optional($course->updated_at)->diffForHumans() ?? 'N/A' }}</span>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('admin.courses.show', $course->id) }}"
                       class="rounded-full bg-white px-5 py-2 text-sm font-semibold text-secondary shadow-card hover:bg-slate-100">
                        Ver detalle
                    </a>

                    @if($course->status === 'pendiente')
                        <form action="{{ route('admin.courses.approve', $course->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-full bg-emerald-100 px-5 py-2 text-sm font-semibold text-emerald-700 shadow-card hover:bg-emerald-200">
                                Aprobar
                            </button>
                        </form>
                        <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="rejection_reason" required
                                   class="min-w-[220px] rounded-2xl border border-slate-200 px-3 py-2 text-sm text-slate-600 focus:border-primary focus:outline-none"
                                   placeholder="Motivo de rechazo">
                            <button type="submit"
                                    class="rounded-full bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-600 shadow-card hover:bg-rose-200">
                                Rechazar
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.courses.reset', $course->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="rounded-full bg-amber-100 px-5 py-2 text-sm font-semibold text-amber-700 shadow-card hover:bg-amber-200">
                                Volver a revisión
                            </button>
                        </form>
                    @endif
                </div>
            </article>
        @empty
            <p class="rounded-3xl border border-dashed border-slate-200 bg-white/80 p-6 text-center text-sm text-slate-500">
                No existen cursos para el estado seleccionado.
            </p>
        @endforelse
    </div>
</div>

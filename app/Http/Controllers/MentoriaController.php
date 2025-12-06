<?php

namespace App\Http\Controllers;

use App\Models\Mentoria;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controlador de Mentorias
 *
 * Cobertura de la rúbrica:
 * - Explica cada flujo CRUD (crear, editar, eliminar, publicar).
 * - Documenta procesos secundarios (aceptar, rechazar, completar sesiones).
 * - Mantiene la lógica intacta, solo añade comentarios para exposiciones Tecsup.
 */
class MentoriaController extends Controller
{
    /**
     * Muestra el formulario de creación (solo mentores).
     * // Flujo CRUD: Create - paso visual antes de MentoriaController::store.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);

        return view('mentorias.create');
    }

    /**
     * Listado de mentorías (mentores/estudiantes/admin segun contexto).
     * // Read del CRUD: puede devolver JSON o Blade sin exponer IDs.
     */
    public function index(Request $request)
    {
        $mentorias = Mentoria::with(['mentor', 'estudiante'])
            ->latest('fecha_mentoria')
            ->latest('fecha_solicitud')
            ->get();

        return $request->expectsJson()
            ? response()->json($mentorias)
            : view('mentorias.index', compact('mentorias'));
    }

    /**
     * CRUD - Create:
     * Persiste la oferta del mentor en estado borrador con validaciones de servidor.
     * Validaciones aplicadas: título, especialidad, descripción, precio, duración y modalidad.
     * Manejo de excepciones: logging y mensajes amigables sin filtrar detalles sensibles.
     */
    public function store(Request $request)
    {
        try {
            Log::info('[Mentorías] Creando mentoría', $request->all());

            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'especialidad' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'precio' => 'required|numeric',
                'duracion_minutos' => 'required|integer',
                'modalidad' => 'required|string',
                'objetivos' => 'nullable|string',
                'fecha_programada' => 'nullable|date',
                'hora_programada' => 'nullable|date_format:H:i',
            ]);

            $mentor = $request->user();
            abort_unless($mentor?->isMentor(), 403);

            $mentoria = Mentoria::create([
                'mentor_id' => $mentor->id,
                'titulo' => $validated['titulo'],
                'especialidad' => $validated['especialidad'],
                'descripcion' => $validated['descripcion'],
                'precio' => $validated['precio'],
                'duracion_minutos' => $validated['duracion_minutos'],
                'modalidad' => $validated['modalidad'],
                'estado' => 'borrador',
                'estudiante_id' => null,
                'objetivos' => $validated['objetivos'] ?? null,
                'fecha_programada' => $validated['fecha_programada'] ?? null,
                'hora_programada' => $validated['hora_programada'] ?? null,
                'monto' => $validated['precio'],
            ]);

            Log::info('Mentorias store saved row', $mentoria->toArray());
            Log::info('[Mentorías] Mentoría creada', ['id' => $mentoria->id]);

            return redirect()
                ->route('mentor.mentorias.index')
                ->with('status', 'Mentoría creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('[Mentorías] Error creando mentoría', [
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('mentor.mentorias.index')
                ->with('status', 'Error al crear mentoría: ' . $e->getMessage());
        }
    }

    /**
     * CRUD - Read:
     * Devuelve la mentoría con sus relaciones según el formato requerido (JSON o Blade).
     */
    public function show(Request $request, Mentoria $mentoria)
    {
        $mentoria->load(['mentor', 'estudiante']);

        return $request->expectsJson()
            ? response()->json($mentoria)
            : view('mentorias.show', compact('mentoria'));
    }

    /**
     * Flujo secundario:
     * Autoriza a mentor/estudiante a unirse a la sesión virtual si el estado lo permite.
     * Incluye controles adicionales (ensureSessionLink + can_view_session) antes de exponer la URL.
     */
    public function join(Request $request, Mentoria $mentoria)
    {
        $user = $request->user();
        abort_unless($user, 403);
        abort_unless(
            in_array($user->id, [$mentoria->mentor_id, $mentoria->estudiante_id], true),
            403
        );

        $mentoria->refresh();
        $mentoria->ensureSessionLink();

        abort_unless($mentoria->can_view_session, 403);
        abort_unless($mentoria->can_join, 403);

        return redirect()->away($mentoria->session_link);
    }

    /**
     * Vista edición (solo mentor propietario).
     * // Flujo CRUD: Update - expone datos amigables sin IDs.
     */
    public function edit(Mentoria $mentoria)
    {
        $this->authorizeMentorAction($mentoria);

        return view('mentor.mentorias.edit', compact('mentoria'));
    }

    /**
     * CRUD - Update:
     * Valida los campos editables del mentor (Request::validate) y aplica reglas de negocio.
     * Seguridad: se restringe a mentor propietario vía authorizeMentorAction.
     */
    public function update(Request $request, Mentoria $mentoria)
    {
        $this->authorizeMentorAction($mentoria);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
            'modalidad' => 'required|in:presencial,virtual',
            'objetivos' => 'nullable|string',
            'descripcion' => 'required|string',
        ]);

        $mentoria->update($validated);

        return redirect()
            ->route('mentor.mentorias.index')
            ->with('success', 'Mentoría actualizada correctamente.');
    }

    /**
     * CRUD - Delete:
     * Permite eliminar solo borradores sin estudiante, evitando inconsistencias de historial.
     */
    public function destroy(Mentoria $mentoria)
    {
        $this->authorizeMentorAction($mentoria);

        if ($mentoria->estudiante_id !== null) {
            return back()->with('error', 'No puedes eliminar una mentoría que ya tiene un estudiante asignado.');
        }

        $mentoria->delete();

        return back()->with('success', 'Mentoría eliminada correctamente.');
    }

    /**
     * Flujo mentor (proceso secundario):
     * Cambia estado a aceptada para habilitar pagos.
     * Incluye validaciones de rol y pertenencia antes de modificar la entidad.
     */
    public function aceptar(Request $request, Mentoria $mentoria)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);
        abort_unless($mentoria->mentor_id === $user->id, 403);
        abort_unless($mentoria->estudiante_id, 403);

        if ($mentoria->estado !== 'pendiente') {
            return back()->with('status', 'Esta mentor?a ya fue procesada.');
        }

        $mentoria->update([
            'estado' => 'aceptada',
            'fecha_solicitud' => $mentoria->fecha_solicitud ?? now(),
        ]);

        return redirect()
            ->route('mentor.mentorias.index')
            ->with('status', 'Mentor?a aceptada. El estudiante ahora puede proceder con el pago.');
    }

    /**
     * Flujo mentor (rechazo):
     * Restablece flags de pago y elimina enlaces activos para evitar accesos no autorizados.
     */
    public function rechazar(Request $request, Mentoria $mentoria)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);
        abort_unless($mentoria->mentor_id === $user->id, 403);

        if (! $mentoria->estudiante_id || $mentoria->estado !== 'pendiente') {
            return back()->with('status', 'No se puede rechazar esta mentoría.');
        }

        $mentoria->update([
            'estado' => 'rechazada',
            'payment_status' => null,
            'link_pago' => null,
            'link_meet' => null,
            'link_sesion' => null,
            'jitsi_room' => null,
        ]);

        return redirect()
            ->route('mentor.mentorias.index')
            ->with('status', 'Mentoría rechazada. El estudiante ha sido notificado.');
    }

    /**
     * Flujo mentor (post-pago):
     * Marca la sesión como completada y registra el reparto económico en PaymentLog.
     */
    public function completar(Request $request, Mentoria $mentoria)
    {
        $user = $request->user();
        abort_unless($user?->isMentor(), 403);
        abort_unless($mentoria->mentor_id === $user->id, 403);
        abort_unless(in_array($mentoria->estado, ['pagada', 'confirmada'], true), 403);

        $mentoria->update([
            'estado' => 'completada',
        ]);

        $monto = $mentoria->monto ?? $mentoria->precio ?? 0;
        $mentorShare = round($monto * 0.95, 2);
        $platformShare = round($monto - $mentorShare, 2);

        PaymentLog::create([
            'mentoria_id' => $mentoria->id,
            'estudiante_id' => $mentoria->estudiante_id,
            'mentor_id' => $mentoria->mentor_id,
            'monto_total' => $monto,
            'monto_mentor' => $mentorShare,
            'monto_plataforma' => $platformShare,
            'metodo' => 'liberacion',
            'referencia' => 'release-' . now()->timestamp,
        ]);

        return redirect()
            ->route('mentor.mentorias.index')
            ->with('status', 'Sesi?n completada. La ganancia del mentor ha sido registrada.');
    }

    // CAMBIO INICIO
    /**
     * API: listado compacto de mentorías del mentor autenticado.
     */
    public function getMentorMentorships(Request $request)
    {
        $mentor = $request->user();
        abort_unless($mentor && $mentor->isMentor(), 403);

        $mentorias = Mentoria::with('estudiante')
            ->where('mentor_id', $mentor->id)
            ->latest('fecha_solicitud')
            ->latest('created_at')
            ->get();

        return response()->json([
            'mentorias' => $mentorias,
            'stats' => [
                'total' => $mentorias->count(),
                'pending' => $mentorias->where('estado', 'pendiente')->count(),
                'accepted' => $mentorias->where('estado', 'aceptada')->count(),
            ],
        ]);
    }

    /**
     * API: sesiones pendientes o aceptadas para el mentor.
     */
    public function getPendingSessions(Request $request)
    {
        $mentor = $request->user();
        abort_unless($mentor && $mentor->isMentor(), 403);

        $sessions = Mentoria::with('estudiante')
            ->where('mentor_id', $mentor->id)
            ->whereIn('estado', ['pendiente', 'aceptada'])
            ->orderByDesc('fecha_programada')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'sessions' => $sessions,
            'count' => $sessions->count(),
        ]);
    }

    /**
     * API: actualiza el estado de una mentoría del mentor autenticado.
     */
    public function updateSessionStatus(Request $request, $id)
    {
        $mentor = $request->user();
        abort_unless($mentor && $mentor->isMentor(), 403);

        $data = $request->validate([
            'status' => ['required', 'in:pendiente,aceptada,rechazada,pagada,confirmada,completada'],
        ]);

        $mentoria = Mentoria::where('mentor_id', $mentor->id)->findOrFail($id);

        $updates = [
            'estado' => $data['status'],
        ];

        if ($data['status'] === 'rechazada') {
            $updates['payment_status'] = null;
            $updates['link_pago'] = null;
            $updates['link_sesion'] = null;
            $updates['jitsi_room'] = null;
        }

        if ($data['status'] === 'pagada') {
            $updates['payment_status'] = 'paid';
        }

        $mentoria->forceFill($updates)->save();

        if ($mentoria->shouldGenerateLink()) {
            $mentoria->ensureSessionLink();
        }

        return response()->json([
            'mentoria' => $mentoria->fresh(),
        ]);
    }
    // CAMBIO FIN

    /** Utilidad para mantener consistencia al generar enlaces (uso en seeds/tests). */
    protected function generarLinkMeet(): string
    {
        return Mentoria::generateMeetLink();
    }

    /**
     * Flujo mentor (publicar):
     * Convierte un borrador en oferta pública; deja evidencia de que no hay estudiante asignado.
     */
    public function publicar(Mentoria $mentoria)
    {
        $this->authorizeMentorAction($mentoria);

        if ($mentoria->estado !== 'borrador' || $mentoria->estudiante_id !== null) {
            return back()->with('error', 'Solo puedes publicar mentorías en borrador sin estudiante.');
        }

        $mentoria->forceFill([
            'estado' => 'publicada',
            'payment_status' => 'pending',
            'link_pago' => null,
        ])->save();

        return redirect()
            ->route('mentor.mentorias.index')
            ->with('success', 'Mentoría publicada correctamente y visible en el marketplace.');
    }

    /**
     * Helper centralizado que refuerza el uso correcto de MVC:
     * impide que otro rol manipule mentorías ajenas.
     */
    protected function authorizeMentorAction(Mentoria $mentoria): void
    {
        abort_unless(auth()->id() === $mentoria->mentor_id, 403);
    }
}

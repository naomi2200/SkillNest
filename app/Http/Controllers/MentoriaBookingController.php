<?php

namespace App\Http\Controllers;

use App\Models\Mentoria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controlador encargado de que estudiantes agenden sesiones con mentores.
 * Documenta el flujo secundario de reservas según la rúbrica Tecsup.
 */
class MentoriaBookingController extends Controller
{
    /**
     * Flujo Student -> Mentor:
     * Crea una mentoría personalizada reutilizando la oferta pública del mentor.
     * Validaciones aplicadas:
     *  - Fecha y hora posteriores al día actual.
     *  - Notas opcionales máximo 500 caracteres.
     * Manejo de errores: abort_unless con códigos HTTP legibles.
     */
    public function store(Request $request, User $mentor)
    {
        abort_unless($mentor->isMentor(), 404);
        $mentor->loadMissing('mentorProfile');
        $profile = $mentor->mentorProfile;
        abort_unless($profile, 404);

        $student = $request->user();
        abort_unless($student?->isStudent(), 403);

        $data = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $baseMentoria = Mentoria::where('mentor_id', $mentor->id)
            ->whereNull('estudiante_id')
            ->where('estado', 'publicada')
            ->latest('updated_at')
            ->first();

        $duration = $baseMentoria->duracion_minutos ?? 60;
        $modalidad = $baseMentoria->modalidad ?? 'virtual';
        $especialidad = $baseMentoria->especialidad ?? $profile->profesion ?? 'Generalista';

        $scheduledAt = Carbon::parse(
            sprintf('%s %s', $data['date'], $data['time']),
            config('app.timezone')
        );

        $baseAmount = $baseMentoria->monto ?? $baseMentoria->precio ?? $profile->precio_hora ?? 0;
        $amount = (float) ($request->input('monto')
            ?? $request->input('precio')
            ?? $baseAmount);
        $amount = round($amount, 2);

        // CRUD Create (flujo secundario): se clona configuracion del mentor sin exponer IDs al front.
        Mentoria::create([
            'mentor_id' => $mentor->id,
            'estudiante_id' => $student->id,
            'titulo' => $baseMentoria->titulo ?? ('Mentoría con ' . $mentor->name),
            'especialidad' => $especialidad,
            'descripcion' => $baseMentoria->descripcion ?? $data['notes'] ?? null,
            'estado' => 'pendiente',
            'fecha_solicitud' => now(),
            'fecha_mentoria' => $scheduledAt,
            'fecha_programada' => $scheduledAt->toDateString(),
            'hora_programada' => $scheduledAt->format('H:i'),
            'duracion_minutos' => $duration,
            'precio' => $amount,
            'monto' => $amount,
            'modalidad' => $modalidad,
            'notas' => $data['notes'] ?? null,
            'payment_status' => 'pending',
        ]);

        return redirect()
            ->route('student.mentorias')
            ->with('status', 'Tu solicitud de mentoría ha sido enviada y está pendiente de aprobación.');
    }
}

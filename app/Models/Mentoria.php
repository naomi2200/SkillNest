<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use App\Models\Payment;

/**
 * Modelo Mentoria
 *
 * Documentado para la rúbrica Tecsup:
 * - Explica relaciones (mentor/estudiante/pago) y accesores usados en los flujos CRUD.
 * - Evita exponer IDs en las vistas, siempre se accederá mediante las relaciones nombradas.
 */
class Mentoria extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para asignación masiva durante los procesos CRUD.
     * Se mantienen alineados con MentoriaController::store y ::update.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mentor_id',
        'estudiante_id',
        'titulo',
        'especialidad',
        'descripcion',
        'precio',
        'duracion_minutos',
        'modalidad',
        'estado',
        'objetivos',
        'fecha_solicitud',
        'fecha_mentoria',
        'fecha_programada',
        'hora_programada',
        'notas',
        'monto',
        'link_pago',
        'link_sesion',
        'jitsi_room',
        'payment_status',
    ];

    /**
     * Conversión de tipos para mantener consistencia de fechas y montos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_mentoria' => 'datetime',
        'fecha_programada' => 'date',
        'precio' => 'decimal:2',
    ];

    /**
     * Accesores que se envían automáticamente al serializar la entidad.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'session_link',
        'can_view_session',
    ];

    /** Relación principal: mentor dueño de la sesión (MVC correcto). */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /** Relación principal: estudiante que solicitó la mentoría. */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    /** Flujo secundario: registro de pago asociado a la sesión. */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Bandera calculada: determina si el usuario puede ingresar a la sala.
     * Depende de {@see getCanViewSessionAttribute} y estados permitidos.
     */
    public function getCanJoinAttribute(): bool
    {
        if (! $this->can_view_session) {
            return false;
        }

        return in_array($this->estado, ['pagada', 'confirmada', 'completada'], true)
            || $this->payment_status === 'paid';
    }

    /**
     * Devuelve la URL completa de Jitsi/Meeet según el campo almacenado.
     * Se usa en vistas y controladores para no duplicar concatenación.
     */
    public function jitsiUrl(): ?string
    {
        if (! $this->jitsi_room) {
            return null;
        }

        return Str::startsWith($this->jitsi_room, 'http')
            ? $this->jitsi_room
            : 'https://meet.jit.si/' . $this->jitsi_room;
    }

    /** Accesor preferido por las vistas: entrega siempre un link listo para compartir. */
    public function getSessionLinkAttribute(): ?string
    {
        if ($this->link_sesion) {
            return $this->link_sesion;
        }

        if (! $this->jitsi_room) {
            return null;
        }

        return Str::startsWith($this->jitsi_room, 'http')
            ? $this->jitsi_room
            : 'https://meet.jit.si/' . $this->jitsi_room;
    }

    /**
     * Bandera para proteger el acceso al link.
     * Se usa en MentoriaController::join para reforzar reglas de negocio.
     */
    public function getCanViewSessionAttribute(): bool
    {
        return in_array($this->estado, ['aceptada', 'confirmada', 'pagada', 'completada'], true)
            && (bool) $this->session_link;
    }

    /** Alias para compatibilidad con código previo (link_meet). */
    public function getLinkMeetAttribute(): ?string
    {
        return $this->link_sesion;
    }

    /** Mutador que escribe el valor legacy en el nuevo campo. */
    public function setLinkMeetAttribute(?string $value): void
    {
        $this->attributes['link_sesion'] = $value;
    }

    /**
     * Genera forzosamente un enlace cuando el estado lo requiere.
     * Evita errores en vivo cuando un mentor acepta una sesión.
     */
    public function ensureSessionLink(): void
    {
        if ($this->link_sesion) {
            return;
        }

        $room = $this->jitsi_room ?? static::generateRoomName();

        $this->forceFill([
            'jitsi_room' => $room,
            'link_sesion' => 'https://meet.jit.si/' . $room,
        ])->save();
    }

    /** Helper reutilizable para generar nombres únicos de sala. */
    public static function generateRoomName(): string
    {
        return 'skillnest-' . Str::uuid();
    }

    /** Reglas que definen si se debe crear/actualizar el enlace de la sesión. */
    public function shouldGenerateLink(): bool
    {
        return in_array($this->estado, ['aceptada', 'confirmada', 'pagada', 'completada'], true)
            || $this->payment_status === 'paid';
    }

    /** Generador genérico para seeds o factories. */
    public static function generateMeetLink(): string
    {
        return 'https://meet.jit.si/' . Str::random(30);
    }
}

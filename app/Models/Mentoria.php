<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Payment;

class Mentoria extends Model
{
    use HasFactory;

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

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_mentoria' => 'datetime',
        'fecha_programada' => 'date',
        'precio' => 'decimal:2'
    ];

    protected $appends = [
        'session_link',
        'can_view_session',
    ];

    // Relación con el mentor
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    // Relación con el estudiante
    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getCanJoinAttribute(): bool
    {
        if (! $this->can_view_session) {
            return false;
        }

        return in_array($this->estado, ['pagada', 'confirmada', 'completada'], true)
            || $this->payment_status === 'paid';
    }

    public function jitsiUrl(): ?string
    {
        if (! $this->jitsi_room) {
            return null;
        }

        return Str::startsWith($this->jitsi_room, 'http')
            ? $this->jitsi_room
            : 'https://meet.jit.si/' . $this->jitsi_room;
    }

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

    public function getCanViewSessionAttribute(): bool
    {
        return in_array($this->estado, ['aceptada', 'confirmada', 'pagada', 'completada'], true)
            && (bool) $this->session_link;
    }

    public function getLinkMeetAttribute(): ?string
    {
        return $this->link_sesion;
    }

    public function setLinkMeetAttribute(?string $value): void
    {
        $this->attributes['link_sesion'] = $value;
    }

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

    public static function generateRoomName(): string
    {
        return 'skillnest-' . Str::uuid();
    }

    public function shouldGenerateLink(): bool
    {
        return in_array($this->estado, ['aceptada', 'confirmada', 'pagada', 'completada'], true)
            || $this->payment_status === 'paid';
    }

    public static function generateMeetLink(): string
    {
        return 'https://meet.jit.si/' . Str::random(30);
    }
}

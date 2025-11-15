<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MentorProfile extends Model
{
    use HasFactory;

    protected $table = 'mentor_profiles';

    protected $fillable = [
        'user_id',
        'foto',
        'profesion',
        'descripcion',
        'experiencia_anios',
        'categorias',
        'skills',
        'precio_hora',
        'nivel_experiencia',
        'rating',
        'reviews_count',
        'is_available',
        'avatar_url',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_available' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentorias()
    {
        return $this->hasMany(Mentoria::class, 'mentor_id', 'user_id');
    }

    public function getDisplaySkillsAttribute(): array
    {
        $raw = $this->skills;

        if (is_array($raw)) {
            return array_filter(array_map('trim', $raw));
        }

        return array_filter(array_map('trim', explode(',', (string) $raw)));
    }

}

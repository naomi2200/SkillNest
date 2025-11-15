<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'title', 
        'description',
        'price',
        'duration', 
        'level',
        'category',
        'image_url',
        'status',
        'objectives',
        'requirements'
    ];

    // Relación con el mentor (usuario)
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    // Relación con estudiantes (si la necesitas después)
    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'curso_estudiante', 'curso_id', 'estudiante_id');
    }
}
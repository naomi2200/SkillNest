<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Purchase;

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
        'rejection_reason',
        'objectives',
        'requirements',
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

    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id');
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            Module::class,
            'course_id',
            'module_id'
        );
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'course_id');
    }

    public function isPurchasedBy(User $user): bool
    {
        return $this->purchases()
            ->where('student_id', $user->id)
            ->where('status', 'paid')
            ->exists();
    }
}

<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Curso;
use App\Models\MentorProfile;
use App\Models\Mentoria;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\StudentProgress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ Agregar role aquí
        'avatar_url',
        'timezone',
        'notification_channel',
        'profile_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verificar si el usuario es mentor
     */
    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    /**
     * Verificar si el usuario es estudiante
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Verificar si el usuario es admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function cursosMentor()
    {
        return $this->hasMany(Curso::class, 'mentor_id');
    }

    public function cursosInscritos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante', 'estudiante_id', 'curso_id')
            ->withPivot('progress')
            ->withTimestamps();
    }

    public function mentoriasComoMentor()
    {
        return $this->hasMany(Mentoria::class, 'mentor_id');
    }

    public function mentoriasComoEstudiante()
    {
        return $this->hasMany(Mentoria::class, 'estudiante_id');
    }

    public function mentorCourses()
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }

    public function courses()
    {
        return $this->mentorCourses();
    }

    public function mentorProfile()
    {
        return $this->hasOne(MentorProfile::class, 'user_id');
    }

    public function coursePurchases()
    {
        return $this->hasMany(Purchase::class, 'student_id');
    }

    public function courseProgress()
    {
        return $this->hasMany(StudentProgress::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }
}

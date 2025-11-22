<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Purchase;
use App\Models\User;

class Course extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public const REVIEW_DRAFT = 'draft';
    public const REVIEW_PENDING = 'pending';
    public const REVIEW_APPROVED = 'approved';
    public const REVIEW_REJECTED = 'rejected';

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('position');
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function quizzes(): HasManyThrough
    {
        return $this->hasManyThrough(Quiz::class, Module::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function estudiantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'curso_estudiante', 'curso_id', 'estudiante_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('review_status', self::REVIEW_APPROVED);
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->mentor_id === $user->id;
    }

    public function isPurchasedBy(User $user): bool
    {
        return $this->purchases()->where('student_id', $user->id)->where('status', 'paid')->exists();
    }
}

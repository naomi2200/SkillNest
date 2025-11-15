<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Module;
use App\Models\StudentProgress;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }
}

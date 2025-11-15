<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentoria_id',
        'student_id',
        'mentor_id',
        'amount',
        'service_fee',
        'total',
        'status',
        'method',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function mentoria()
    {
        return $this->belongsTo(Mentoria::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}

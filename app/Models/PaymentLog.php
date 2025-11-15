<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentoria_id',
        'estudiante_id',
        'mentor_id',
        'monto_total',
        'monto_mentor',
        'monto_plataforma',
        'metodo',
        'referencia',
    ];
}

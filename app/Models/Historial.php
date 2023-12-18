<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'tractament_id',
        'user_id',
        'data',
        'hora',
        'data_cancelacio',
        'motiu_cancelacio',
    ];
}

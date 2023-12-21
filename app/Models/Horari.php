<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horari extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'hora_obertura',
        'hora_tancament',
    ];
}

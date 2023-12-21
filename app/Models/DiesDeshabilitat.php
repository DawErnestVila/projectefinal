<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiesDeshabilitat extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'motiu',
    ];
}

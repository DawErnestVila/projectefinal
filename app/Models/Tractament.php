<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tractament extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'descripcio',
        'durada',
    ];

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }
}

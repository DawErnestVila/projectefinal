<?php

namespace App\Models;

use App\Models\Reserve;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'cognoms',
        'correu',
        'telefon',
    ];


    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    public function historial()
    {
        return $this->hasMany(Historial::class);
    }
}

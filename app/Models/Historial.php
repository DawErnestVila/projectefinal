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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tractament()
    {
        return $this->belongsTo(Tractament::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

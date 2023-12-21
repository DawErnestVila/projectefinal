<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'tractament_id',
        'data',
        'hora',
        'comentari',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tractament()
    {
        return $this->belongsTo(Tractament::class);
    }
}

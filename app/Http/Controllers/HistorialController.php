<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {
        $historials = Historial::all();
        return view('historial', [
            'historials' => $historials,
        ]);
    }
}

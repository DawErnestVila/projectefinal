<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function toggleStatus(Request $request, User $user)
    {
        // Verifica si l'alumne està habilitat i actualitza l'estat oposat
        $user->update(['habilitat' => !$user->habilitat]);

        // Pots redirigir a alguna altra ruta o simplement mostrar un missatge
        return back()->with('success', 'Estat de l\'alumne actualitzat amb èxit.');
    }
}

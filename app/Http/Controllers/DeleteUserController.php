<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeleteUserController extends Controller
{
    public function destroy(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        //Revisar que la $request->input('password') sigui la contrasenya de l'usuari autenticat
        if (auth()->check() && Hash::check($request->input('password'), auth()->user()->password)) {

            if (auth()->user()->name === 'Professorat') {
                // Your logic to delete the user should go here
                $user->delete();

                // Redirect or return a response as needed
                return redirect()->route('gestionar-alumnes')->with('success', 'Alumne eliminat correctament.');
            }

            // If the user does not have the necessary permissions, handle accordingly
            return redirect()->route('gestionar-alumnes')->with('error', 'No tens permisos per eliminar aquest alumne.');
        }
        return redirect()->route('gestionar-alumnes')->with('error', 'Contrasenya incorrecta o usuari no autenticat.');
    }
}

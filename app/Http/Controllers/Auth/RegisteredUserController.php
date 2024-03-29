<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Historial;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $users = User::all();
        $historialsGroupedByUser = Historial::all()->groupBy('user_name');

        $usersWithTasks = [];

        foreach ($users as $user) {
            $userHistorials = $historialsGroupedByUser->get($user->name, []);

            $historialsCount = count($userHistorials);

            $usersWithTasks[] = [
                "user" => $user,
                "historials" => $historialsCount,
            ];
        }
        // dd($usersWithTasks);

        return view('auth.register', [
            'users' => $usersWithTasks,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('gestionar-alumnes')->with('success', 'Alumne creat correctament');
    }
}

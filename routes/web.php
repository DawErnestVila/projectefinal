<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Psr7\Request as GuzzleRequequest;
use Inertia\Inertia;
use Illuminate\Http\Request as IlluminateRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return Inertia::render('Layout');
})->name('home');

Route::get('/demanar-hora', function () {
    return Inertia::render('Layout');
})->name('demanar-hora');

Route::post('/demanar-hora', function (IlluminateRequest $request) {
    $telefon = $request->input('telefon');

    // Aquí pots buscar l'usuari a la base de dades
    //? $user = User::where('telefon', $telefon)->first();
    $user = [
        'id' => 1, // Aquesta és la clau primària de la taula 'users
        'nom' => 'Ernest',
        'cognoms' => 'Vilà',
        'telefon' => $telefon,
        'email' => 'ernestvila@gmail.com',
    ];

    // $user = null;
    // dd($user);

    if ($user) {
        // Si l'usuari ja existeix, torna les dades de l'usuari a la vista
        return Inertia::render('Layout', [
            'user' => $user,
        ]);
    } else {
        // Si l'usuari no existeix, pots manejar-ho com vulguis
        // En aquest exemple, simplement redirigim a una altra pàgina d'error
        return Inertia::render('Error');
    }
})->name('demanar-hora-post');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

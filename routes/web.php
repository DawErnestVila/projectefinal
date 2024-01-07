<?php

use Inertia\Inertia;
use App\Models\Reserve;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HorariController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\DeleteUserController;
use App\Http\Controllers\TractamentController;
use GuzzleHttp\Psr7\Request as GuzzleRequequest;
use Illuminate\Http\Request as IlluminateRequest;
use App\Http\Controllers\DiesDeshabilitatController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::get('/', [ClientController::class, 'index'])->name('home');
Route::post('/', [ClientController::class, 'indexPost']);

Route::get('/demanar-hora', [ClientController::class, 'demanarHoraGet'])->name('demanar-hora');

Route::post('/demanar-hora', [ClientController::class, 'demanarHoraPost'])->name('demanar-hora-post');

Route::get('send-mail', [MailController::class, 'index']);

Route::get('/dashboard', function () {
    $reserves = [];

    if (auth()->user()->name == 'Professorat') {
        $reserves = Reserve::orderBy('data', 'asc')->orderBy('hora', 'asc')->get();
    }

    return view('dashboard', [
        'reserves' => $reserves,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['professorat'])->group(function () {
    Route::get('gestionar-alumnes', [RegisteredUserController::class, 'create'])
        ->name('gestionar-alumnes');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::delete('/delete-user', [DeleteUserController::class, 'destroy'])->name('delete.user');
    Route::get('/historial-reserves', [HistorialController::class, 'index'])->name('historial-reserves');
    Route::get('/gestionar-horaris', [HorariController::class, 'gestionarHoraris'])->name('gestionar-horaris');
    Route::put('/actualizar-horaris', [HorariController::class, 'actualizarHoraris'])->name('actualitza-horaris');
    Route::post('/acutalitzardiesdeshabilitats', [DiesDeshabilitatController::class, 'actualitzarDiesDeshabilitats'])->name('actualitzar-dies-deshabilitats');
    Route::get('/gestionar-tractaments', [TractamentController::class, 'gestionarTractaments'])->name('gestionar-tractaments');
    Route::put('/editar-tractament', [TractamentController::class, 'editarTractament'])->name('editar-tractament');
    Route::post('/crear-tractament', [TractamentController::class, 'crearTractament'])->name('crear-tractament');
    Route::post('/cancelar-reserva', [ReservaController::class, 'cancelarReserva'])->name('cancelar-reserva');
    Route::put('/user/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle.user.status');
});

require __DIR__ . '/auth.php';

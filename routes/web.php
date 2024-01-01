<?php

use Inertia\Inertia;
use App\Models\Reserve;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeleteUserController;
use GuzzleHttp\Psr7\Request as GuzzleRequequest;
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


require __DIR__ . '/auth.php';

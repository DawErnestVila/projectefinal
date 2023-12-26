<?php

use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HorariController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\TractamentController;
use App\Http\Controllers\DiesDeshabilitatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/existeixclient', [ClientController::class, 'existeixClientApi'])->name('existeixclient');
Route::post('/storeclient', [ClientController::class, 'storeClientApi'])->name('storeclient');
Route::get('/gettractaments', [TractamentController::class, 'getTractamentsApi'])->name('gettractaments');
Route::get('/gethoraris', [HorariController::class, 'getHorarisApi'])->name('getoraris');
Route::get('/getdiesdeshabilitats', [DiesDeshabilitatController::class, 'getDiaDeshabilitatsApi'])->name('getdiesdesabilitats');
Route::post('/gethoresdisponibles', [HorariController::class, 'getHoresDisponiblesApi'])->name('gethoresdisponibles');
Route::post('/getreservesdia', [ReservaController::class, 'getReservesDia'])->name('getreservesdia');
Route::post('/gettractamentid', [TractamentController::class, 'getTractamentId'])->name('gettractamentid');
Route::post('/storereserva', [ReservaController::class, 'storeReserva'])->name('storereserva');
Route::get('/getreserves', [ReservaController::class, 'getReserves'])->name('getreserves');
Route::post('/getclientbyid', [ClientController::class, 'getClientById'])->name('getclientbyid');
Route::post('/assignarreserva', [ReservaController::class, 'assignarReserva'])->name('assignarreserva');
Route::post('/getfilteredhistorial', [HistorialController::class, 'getFilteredHistorial'])->name('getfilteredhistorial');
Route::post('/deleetetractament', [TractamentController::class, 'deleteTractament'])->name('deleetetractament');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

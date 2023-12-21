<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HorariController;
use App\Http\Controllers\TractamentController;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

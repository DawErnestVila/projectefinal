<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Reserva;
use App\Models\Reserve;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function getReservesDia(Request $request)
    {
        $data = $request->dia;
        $dateFromFormat = DateTime::createFromFormat('d/m/Y', $data);
        $dataSenseHora = $dateFromFormat->format('Y-m-d');
        $reserves = Reserve::where('data', $dataSenseHora)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $reserves,
        ]);
    }
}

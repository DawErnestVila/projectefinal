<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Reserva;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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

    public function storeReserva(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        // Validate the input
        $validator = Validator::make($data, [
            'client_id' => 'required',
            'tractament_id' => 'required',
            'dia' => 'required',
            'hora' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Error al crear la reserva');
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear la reserva',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Falta passar la data de format d/m/Y a Y-m-d
        $dateFromFormat = DateTime::createFromFormat('d/m/Y', $data['dia']);

        // If validation passes, create the client
        $reserva = Reserve::create([
            'client_id' => $data['client_id'],
            'tractament_id' => $data['tractament_id'],
            'data' => $dateFromFormat,
            'hora' => $data['hora'],
            'comentari' => $data['missatge'],
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Reserva creada correctament',
            'data' => $reserva,
        ]);
    }
}

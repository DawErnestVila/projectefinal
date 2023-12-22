<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Reserva;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\ReservationConfirmationMail;
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

        //TODO S'hauria d'enviar un correu al client amb la confirmació de la reserva
        // Get the client's email address
        $clientEmail = $reserva->client->correu;

        // Check if the email address is valid
        if (filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
            // Send confirmation email to the client
            Mail::to($clientEmail)->send(new ReservationConfirmationMail($reserva));

            return response()->json([
                'status' => 'success',
                'message' => 'Reserva creada correctament',
                'data' => $reserva,
            ]);
        } else {
            // Handle the case where the email address is not valid
            return response()->json([
                'status' => 'error',
                'message' => 'Error al enviar el correu. La direcció de correu electrònic no és vàlida.',
            ], 400);
        }
    }

    public function getReserves()
    {
        $reserves = Reserve::all();
        $response = array();

        foreach ($reserves as $reserva) {
            $response[] = [
                'reserva' => $reserva,
                'client' => $reserva->client,
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $response,
        ]);
    }
}

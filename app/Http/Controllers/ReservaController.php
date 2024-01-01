<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Reserva;
use App\Models\Reserve;
use App\Models\Historial;
use App\Models\Tractament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\ReservationCancellationMail;
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
        // Elimina les reserves anteriors a avui
        $reserves = Reserve::all();
        $today = date('Y-m-d');
        foreach ($reserves as $reserva) {
            if ($reserva->data < $today) {
                $historial = Historial::create([
                    "client_name" => Client::find($reserva->client_id)->nom,
                    "tractament_name" => Tractament::find($reserva->tractament_id)->nom,
                    "user_name" => "-",
                    "data" => $reserva->data,
                    "hora" => $reserva->hora,
                    "data_cancelacio" => $today,
                    "motiu_cancelacio" => "El client no ha vingut a la reserva",
                ]);
                Reserve::destroy($reserva->id);
            }
        }

        //Funcionament de la funcio

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

        $dateFromFormat = DateTime::createFromFormat('d/m/Y', $data['dia']);

        // If validation passes, create the client
        $reserva = Reserve::create([
            'client_id' => $data['client_id'],
            'tractament_id' => $data['tractament_id'],
            'data' => $dateFromFormat,
            'hora' => $data['hora'],
            'comentari' => $data['missatge'],
        ]);

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
                "tractament" => $reserva->tractament,
            ];
        }

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $response,
        ]);
    }

    public function assignarReserva(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // Validate the input
        $validator = Validator::make($data, [
            'reserva_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Error al assignar la reserva');
            return response()->json([
                'status' => 'error',
                'message' => 'Error al assignar la reserva',
                'errors' => $validator->errors(),
            ], 400);
        }

        $reserva = Reserve::find($data['reserva_id']);
        $tractamentId = $reserva->tractament_id;
        $dataRes = $reserva->data;
        $hora = $reserva->hora;
        $clientId = $reserva->client_id;

        // dd($tractamentId, $dataRes, $hora);

        $historial = Historial::create([
            "client_name" => Client::find($clientId)->nom,
            "tractament_name" => Tractament::find($tractamentId)->nom,
            "user_name" => User::find($data['user_id'])->name,
            "data" => $dataRes,
            "hora" => $hora,
        ]);

        // Ara faria eliminar la reserva de la taula reserves ja que ja està al historial i assignada a un treballador
        Reserve::destroy($data['reserva_id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Reserva assignada correctament',
            'data' => $historial,
        ]);
    }

    public function cancelarReserva(Request $request)
    {
        $reserva_id = $request->reserva_id;
        $motiu = $request->motiu;

        // Get the reservation details
        $reserva = Reserve::find($reserva_id);
        $clientEmail = $reserva->client->correu;

        // Convert the date string to a Carbon object
        $dataResCarbon = Carbon::createFromFormat('Y-m-d', $reserva->data);

        // Format the date as 'd/m/Y'
        $dataResFormatted = $dataResCarbon->format('d/m/Y');

        // Store reservation details for history
        $historial = Historial::create([
            "client_name" => $reserva->client->nom,
            "tractament_name" => $reserva->tractament->nom,
            "user_name" => "-",
            "data" => $dataResCarbon,
            "hora" => $reserva->hora,
            "data_cancelacio" => now(),
            "motiu_cancelacio" => $motiu,
        ]);

        // Delete the reservation
        Reserve::destroy($reserva_id);

        // Send cancellation email to the client
        if (filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::to($clientEmail)->send(new ReservationCancellationMail($reserva, $motiu, $dataResFormatted));
        }

        return redirect()->route('dashboard')->with('success', 'Reserva cancel·lada correctament');
    }
}

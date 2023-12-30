<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {
        $historials = Historial::orderBy('data', 'desc')->paginate(10);

        return view('historial', [
            'historials' => $historials,
        ]);
    }

    public function getFilteredHistorial(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $client_name = $data['client_name'];
        $tractament_name = $data['tractament_name'];
        $user_name = $data['alumne_name'];
        $cancelada = $data['cancelada'];

        $historialsQuery = Historial::query();
        $conditionsAdded = false;

        if ($client_name !== null && isset($client_name) && $client_name !== '') {
            $historialsQuery->where('client_name', 'LIKE', '%' . $client_name . '%');
            $conditionsAdded = true;
        }

        if ($user_name !== null && isset($user_name) && $user_name !== '') {
            $historialsQuery->where('user_name', 'LIKE', '%' . $user_name . '%');
            $conditionsAdded = true;
        }

        if ($tractament_name !== null && isset($tractament_name) && $tractament_name !== '') {
            $historialsQuery->where('tractament_name', $tractament_name);
            $conditionsAdded = true;
        }

        if ($data['data'] !== null && isset($data['data']) && $data['data'] !== '') {
            $dataHist = $data['data'];

            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $dataHist)) {
                $dataHist = date_create_from_format('d/m/Y', $dataHist);

                $date = date_format($dataHist, 'Y-m-d');

                dd("arribo aqui" . $date);

                if ($date !== null) {
                    $historialsQuery->where('data', $date);
                    $conditionsAdded = true;
                }
            }
        }

        if ($cancelada !== null && isset($cancelada) && $cancelada !== '' && $cancelada === true) {
            $historialsQuery->whereNotNull('data_cancelacio');
            $conditionsAdded = true;
        }

        $historials = null;
        if ($conditionsAdded && $historialsQuery->exists()) {
            $historials = $historialsQuery->orderBy('data', 'desc')->get();
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Reserva assignada correctament',
            'data' => $historials,
        ]);
    }
}

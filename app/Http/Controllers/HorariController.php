<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Horari;
use Illuminate\Http\Request;

class HorariController extends Controller
{
    public function getHorarisApi()
    {
        $horaris = Horari::all();

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $horaris,
        ]);
    }

    public function getHoresDisponiblesApi(Request $request)
    {
        //Aqui rebo una data amb format dd/mm/yyyy
        //necessito saber el dia de la setmana que es per poder fer la query

        $data = $request->dia;
        $dateFromFormat = DateTime::createFromFormat('d/m/Y', $data);
        $dia = $dateFromFormat->format('N');

        $horaris = Horari::where('dia', $dia)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $horaris,
        ]);
    }
}
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

    public function gestionarHoraris()
    {
        $horaris = Horari::all();
        return view('gestionarHoraris', [
            'horaris' => $horaris,
        ]);
    }

    public function actualizarHoraris(Request $request)
    {
        $request->validate([
            'dies' => 'required|array',
            'hores.*.hora_obertura' => 'nullable|date_format:H:i',
            'hores.*.hora_tancament' => 'nullable|date_format:H:i',
        ]);
        $dies = $request->dies;
        $hores = $request->hores;

        $diesABorrar = Horari::whereNotIn('dia', $dies)->pluck('dia');

        Horari::whereIn('dia', $diesABorrar)->delete();


        foreach ($dies as $dia) {
            $horari = Horari::where('dia', $dia)->first();

            // Existeix
            if ($horari) {
                // Actualitza les hores amb les dades corresponents
                $horari->hora_obertura = $hores[$dia]['hora_obertura'];
                $horari->hora_tancament = $hores[$dia]['hora_tancament'];
                $horari->save();
            } else {
                // No existeix, crea una nova entrada amb les dades corresponents
                Horari::create([
                    'dia' => $dia,
                    'hora_obertura' => $hores[$dia]['hora_obertura'],
                    'hora_tancament' => $hores[$dia]['hora_tancament'],
                ]);
            }
        }

        return redirect()->route('gestionar-horaris')->with('success', 'Horaris actualitzats amb èxit');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DiesDeshabilitat;
use DateTime;
use Carbon\Carbon;
use App\Models\Horari;
use App\Models\Reserve;
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
        $diesDeshabilitats = DiesDeshabilitat::all()->pluck('data')->toArray();
        $dates = [];
        foreach ($diesDeshabilitats as $data) {
            $dateFromFormat = DateTime::createFromFormat('Y-m-d', $data);
            $dates[] = $dateFromFormat->format('d/m/Y');
        }
        // dd($dates);
        return view('gestionarHoraris', [
            'horaris' => $horaris,
            'diesDeshabilitats' => $dates,
        ]);
    }

    public function actualizarHoraris(Request $request)
    {
        $request->validate([
            'dies' => 'required|array',
            'hores.*.hora_obertura' => ['nullable', 'date_format:H:i', function ($attribute, $value, $fail) {
                $minutes = explode(':', $value)[1];
                if (!in_array($minutes, ['00', '15', '30', '45'])) {
                    $fail($attribute . ' ha de tenir els minuts com a 00, 15, 30 o 45.');
                }
            }],
            'hores.*.hora_tancament' => ['nullable', 'date_format:H:i', 'after:hores.*.hora_obertura', function ($attribute, $value, $fail) {
                $minutes = explode(':', $value)[1];
                if (!in_array($minutes, ['00', '15', '30', '45'])) {
                    $fail($attribute . ' ha de tenir els minuts com a 00, 15, 30 o 45.');
                }
            }],
        ]);
        $dies = $request->dies;
        $hores = $request->hores;
        $diesABorrar = Horari::whereNotIn('dia', $dies)->pluck('dia');

        $reserves = Reserve::all();
        foreach ($reserves as $reserva) {
            $data = $reserva->data;
            $dateFromFormat = DateTime::createFromFormat('Y-m-d', $data);
            // Afaga el numero del dia de la setmana
            $dia = $dateFromFormat->format('N');
            if (in_array($dia, $diesABorrar->toArray())) {
                return redirect()->route('gestionar-horaris')->with('error', 'No es pot eliminar un dia que té reserves');
            }
        }

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

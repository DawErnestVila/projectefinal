<?php

namespace App\Http\Controllers;

use App\Models\Horari;
use App\Models\Tractament;
use Illuminate\Http\Request;

class TractamentController extends Controller
{
    public function getTractamentsApi()
    {
        $tractaments = Tractament::all();

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $tractaments,
        ]);
    }

    public function getTractamentId(Request $request)
    {
        $tractament = Tractament::where('id', $request->id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $tractament,
        ]);
    }

    public function gestionarTractaments()
    {
        $tractaments = Tractament::all();

        return view('gestionarTractaments', [
            'tractaments' => $tractaments,
        ]);
    }

    public function editarTractament(Request $request)
    {
        $tractament = Tractament::find($request->tractament_id);

        if ($tractament) {
            $hores = str_pad($request->hores, 2, '0', STR_PAD_LEFT); // Afegeix un zero a l'esquerra si és necessari
            $minuts = str_pad($request->minuts, 2, '0', STR_PAD_LEFT); // Afegeix un zero a l'esquerra si és necessari

            $durada = $hores . ':' . $minuts;

            // Actualitza la informació del tractament
            $tractament->nom = $request->nom;
            $tractament->descripcio = $request->descripcio;
            $tractament->durada = $durada;

            $tractament->save();

            return redirect()->route('gestionar-tractaments')->with('success', 'Tractament actualitzat amb èxit');
        }

        return redirect()->route('gestionar-tractaments')->with('error', 'No s\'ha trobat cap tractament amb aquest ID');
    }

    public function deleteTractament(Request $request)
    {
        $tractament = Tractament::where('id', $request->id)->first();

        $tractament->delete();

        return redirect()->route('gestionarTractaments');
    }
}

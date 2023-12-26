<?php

namespace App\Http\Controllers;

use App\Models\Horari;
use App\Models\Reserve;
use App\Models\Tractament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $data = json_decode($request->getContent(), true);

        $tractament = Tractament::where('id', $data['tractament_id'])->first();

        $reserves = Reserve::where('tractament_id', $tractament->id)->get();


        if ($reserves) {
            return response()->json([
                'status' => 'error',
                'message' => 'No es pot eliminar el tractament perquè hi ha reserves assignades',
                'data' => $tractament,
            ]);
        }

        $tractament->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tractament eliminat correctament',
            'data' => $tractament,
        ]);
    }

    public function crearTractament(Request $request)
    {

        $request->validate(
            [
                'nom' => 'required',
                'descripcio' => 'required',
                'hores' => 'required|numeric|min:0|max:23',
                'minuts' => 'required|numeric|min:0|max:59',
            ]
        );

        $nom = $request->nom;
        $descripcio = $request->descripcio;
        $hores = str_pad($request->hores, 2, '0', STR_PAD_LEFT);
        $minuts = str_pad($request->minuts, 2, '0', STR_PAD_LEFT);
        $duracio = $hores . ':' . $minuts;

        $tractament = Tractament::create([
            'nom' => $nom,
            'descripcio' => $descripcio,
            'durada' => $duracio,
        ]);


        return redirect()->route('gestionar-tractaments')->with('success', 'El tractament ' . $request->nom . " s'ha creat amb èxit");
    }
}

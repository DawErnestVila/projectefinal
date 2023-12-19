<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Client;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        return Inertia::render('Layout');
    }

    public function demanarHoraGet()
    {
        return Inertia::render('Layout');
    }

    public function demanarHoraPost(Request $request)
    {
        $telefon = $request->input('telefon');

        // Aquí pots buscar l'usuari a la base de dades
        $user = Client::where('telefon', $telefon)->first();

        if ($user) {
            // Si l'usuari ja existeix, torna les dades de l'usuari a la vista
            return Inertia::render('Layout', [
                'user' => $user,
            ]);
        } else {
            // Si l'usuari no existeix, pots manejar-ho com vulguis
            // En aquest exemple, simplement redirigim a una altra pàgina d'error
            return Inertia::render('Error');
        }
    }

    public function existeixClientApi(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() == JSON_ERROR_NONE) {
            $client = Client::where('telefon', $data['telefon'])->first();
            if ($client) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'JSON received successfully',
                    'data' => true,
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'JSON received successfully',
                    'data' => false,
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid JSON format',
            ], 400);
        }
    }

    public function storeClientApi(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // Validate the input
        $validator = Validator::make($data, [
            'nom' => 'required',
            'cognoms' => 'required',
            'telefon' => 'required',
            'correu' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        // If validation passes, create the client
        $client = Client::create([
            'nom' => $data['nom'],
            'cognoms' => $data['cognoms'],
            'correu' => $data['correu'],
            'telefon' => $data['telefon'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Client created successfully',
            'data' => $client,
        ]);
    }
}

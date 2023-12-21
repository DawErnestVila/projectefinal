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
}

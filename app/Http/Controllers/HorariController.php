<?php

namespace App\Http\Controllers;

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
}

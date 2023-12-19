<?php

namespace App\Http\Controllers;

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
}

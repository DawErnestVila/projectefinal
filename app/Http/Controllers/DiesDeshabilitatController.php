<?php

namespace App\Http\Controllers;

use App\Models\DiesDeshabilitat;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class DiesDeshabilitatController extends Controller
{
    public function getDiaDeshabilitatsApi()
    {
        $diaDeshabilitats = DiesDeshabilitat::all();

        return response()->json([
            'status' => 'success',
            'message' => 'JSON received successfully',
            'data' => $diaDeshabilitats,
        ]);
    }
}

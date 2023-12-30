<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use App\Models\Reserve;
use Illuminate\Http\Request;
use App\Models\DiesDeshabilitat;

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

    public function actualitzarDiesDeshabilitats(Request $request)
    {
        // Elimina les dates anteriors a avui
        $today = date('Y-m-d');
        DiesDeshabilitat::where('data', '<', $today)->delete();

        $dies = $request->dates;
        $dies = explode(', ', $dies);

        $dates = [];
        foreach ($dies as $data) {
            $dateFromFormat = DateTime::createFromFormat('d/m/Y', $data);
            $dates[] = $dateFromFormat->format('Y-m-d');
        }
        $datesDB = DiesDeshabilitat::all()->pluck('data')->toArray();

        $datesToAdd = array_diff($dates, $datesDB);

        $datesToDelete = array_diff($datesDB, $dates);

        $datesNotChanged = [];
        foreach ($datesToAdd as $data) {
            // Comprova si hi ha una reserva per aquesta data
            if (Reserve::where('data', $data)->exists()) {
                $datesNotChanged[] = $data;
                continue;
            }

            $dateFromFormat = DateTime::createFromFormat('Y-m-d', $data);
            $date = $dateFromFormat->format('Y-m-d');
            $diaDeshabilitat = new DiesDeshabilitat();
            $diaDeshabilitat->data = $date;
            $diaDeshabilitat->save();
        }
        foreach ($datesToDelete as $data) {
            // Comprova si hi ha una reserva per aquesta data
            if (Reserve::where('data', $data)->exists()) {
                $datesNotChanged[] = $data;
                continue;
            }

            $dateFromFormat = DateTime::createFromFormat('Y-m-d', $data);
            $date = $dateFromFormat->format('Y-m-d');
            $diaDeshabilitat = DiesDeshabilitat::where('data', $date)->first();
            $diaDeshabilitat->delete();
        }

        $message = 'Dies deshabilitats actualitzats amb èxit';
        if (!empty($datesNotChanged)) {
            $error_message = 'No s\'han pogut canviar els dies: ' . implode(', ', $datesNotChanged);
            return redirect()->route('gestionar-horaris')->with('success', $message)->with('error', $error_message);
        }

        return redirect()->route('gestionar-horaris')->with('success', $message);
    }
}

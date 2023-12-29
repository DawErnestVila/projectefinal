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

    public function actualitzarDiesDeshabilitats(Request $request)
    {
        //el request de dates és un string que ve separat per una coma i un espai
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

        foreach ($datesToAdd as $data) {
            $dateFromFormat = DateTime::createFromFormat('Y-m-d', $data);
            $date = $dateFromFormat->format('Y-m-d');
            $diaDeshabilitat = new DiesDeshabilitat();
            $diaDeshabilitat->data = $date;
            $diaDeshabilitat->save();
        }
        foreach ($datesToDelete as $data) {
            $dateFromFormat = DateTime::createFromFormat('Y-m-d', $data);
            $date = $dateFromFormat->format('Y-m-d');
            $diaDeshabilitat = DiesDeshabilitat::where('data', $date)->first();
            $diaDeshabilitat->delete();
        }
        return redirect()->route('gestionar-horaris')->with('success', 'Dies deshabilitats actualitzats amb èxit');
    }
}

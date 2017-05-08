<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Boat;
use App\Calendar;
use Carbon\Carbon;

class CalendarController extends Controller
{
    //
    
    public function index()
    {
        return view('calendar.index');
    }

    public function getCalendar(Request $request)
    {
        //$boats = Boat::all();
        $dayBefore = $request->has('dayBefore') && is_int($request->dayBefore) ? $request->dayBefore : 1;
        $dayAfter = $request->has('dayAfter') && is_int($request->dayAfter) ? $request->dayAfter : 7;
        $dateStart = Carbon::now(3)->subDay($dayBefore)->startOfDay();
        $dateEnd = Carbon::now(3)->addDay($dayAfter + 1)->startOfDay();

        $calendar = Calendar::where('event_date', '>=', $dateStart)->where('event_date', '<', $dateEnd)
            ->with('users')
            ->orderBy('event_date', 'ASC')
            ->get();
        $boats = $calendar->groupBy('boat_id');
        $boatNames = [];
        $boats->each(function ($item, $key) use (&$boatNames) {
            //$item->put('boat_name', Boat::find($key)->boat_name);
            $boatNames[] = Boat::find($key)->boat_name;
        });
       // dump($calendar);

        return json_encode([
            'boats' => $boats,
            'boatNames' => $boatNames,
            'dateStart' => $dateStart->toDateTimeString(),
            'dateEnd' => $dateEnd->toDateTimeString(),
        ]);
    }
}

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
        $dateStart = Carbon::now()->subDay($dayBefore);
        $dateEnd = Carbon::now()->addDay($dayAfter);

        $calendar = Calendar::where('event_date', '>', $dateStart)->where('event_date', '<', $dateEnd)
            ->with('users')
            //->with('boat')
            ->get();
        $boats = $calendar->groupBy('boat_id');
       // dump($calendar);

        return json_encode([
           // 'calendar' => $calendar,
            'boats' => $boats
        ]);
    }
}

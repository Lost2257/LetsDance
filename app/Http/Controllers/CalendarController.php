<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventListResource;
use App\Models\EventList;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function aaad()
    {
        return EventListResource::collection(EventList::all());
    }

    public function calendarEvents(Request $request)
    {
        $eventList = EventList::get(['event_name','event_start','event_end']);
        return response()->json(["My events" => $eventList]);
    }

    public function store(Request $request)
    {
        $new_calendar = EventList::create($request->all());
        return response()->json([
            'data' => new EventListResource($new_calendar),
            'message' => 'successfully added new event!',
        ],200);
    }

    public function show(EventList $calendar)
    {
        return response($calendar, 200);
    }

    public function update(Request $request, EventList $calendar)
    {
        $calendar->update($request->all());
        return response()->json([
            'data' => new EventListResource($calendar),
            'message' => 'paejo',
        ],200);
    }

    public function destroy($id)
    {
        $event = EventList::find($id);
        $event -> delete();
        return response()->json('deleted');
    }
    public function admin()
    {
        return view('/admin');
    }
}

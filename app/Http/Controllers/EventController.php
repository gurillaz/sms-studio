<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateEventRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return Response::json([
            'events' => $events,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(CreateEventRequest $request){

            
            $validated = $request->validated();
         
;
            $event = new Event();
            

            $event->name = $validated['name'];
            $event->address = $validated['address'];
            $dt_date_start =Carbon::parse($validated['date_start']);
            $dt_end_date =Carbon::parse($validated['date_start'])->addHours($validated['duration_hours']);;

            $date_start = $dt_date_start ->format('Y-m-d H:i:s');
            $end_date = $dt_end_date ->format('Y-m-d H:i:s');

            $event->date_start = $date_start;
            $event->date_end= $end_date;
            // return $event;
            

            $event->description = $validated['description'];
            $event->deleted_at =Carbon::parse( $request['deleted_at'])->format('Y-m-d H:m:s');
            $event->status = $request['status'];
            $event->created_by = Auth::id();

            $event->save();


        return Response::json([
            'message' => "Event created!",
            'event' => $event,
        ], 200);

    }
    /**
     * Validate CreeateEvent request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function checkCreateEventValidation(CreateEventRequest $request){


            if($request->validated()){
                return Response::json([
                    'message' => "Validated",

                ], 200);
            }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
//        return $event;
        return view('event.event',compact('event',$event));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if(\request()->ajax()){
            $event->delete();
            $event->save();



            return ['status' => 'success', 'message' => 'Event deleted!'];

        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
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
        $resources = Event::with(['job.client:id,name', 'user:id,name'])->get();



        return Response::json([
            'resources' => $resources
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jobs'] = Job::with(['client:id,name', 'offer:id,name'])->get();



        return Response::json([
            'autofill_data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(CreateEventRequest $request)
    {


        $validated = $request->validated();;
        $event = new Event();


        $event->name = $validated['name'];
        $event->address = $validated['address'];
        $dt_date_start = Carbon::parse($validated['date_start']);
        $dt_end_date = Carbon::parse($validated['date_start'])->addHours($validated['duration_hours']);;

        $date_start = $dt_date_start->format('Y-m-d H:i:s');
        $end_date = $dt_end_date->format('Y-m-d H:i:s');

        $event->date_start = $date_start;
        $event->date_end = $end_date;
        // return $event;


        $event->description = $validated['description'];


        if (isset($validated['job_id'])) {
            $event->job_id = $validated['job_id'];
        }
        if (isset($validated['deleted_at'])) {
            $event->deleted_at = Carbon::parse($validated['deleted_at'])->format('Y-m-d H:m:s');
        }
        
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

    public function checkCreateEventValidation(CreateEventRequest $request)
    {


        if ($request->validated()) {
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
        //              $types = Inventory::all()->pluck('type');
        // $suppliers = Inventory::all()->pluck('supplier');

        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $event;
        $resource['created_by'] = $event->user()->first('name');
        $resource['class_name'] = $event->getMorphClass();

        $resource_relations['job'] = $event->job;

        $resource_relations['tasks'] = $event->tasks()->with('user:id,name','employee:id,name','event:id,name')->get();

        $resource_relations['notes'] = $event->notes()->with('user:id,name','noteable:id,name')->get();
        $resource_relations['files'] = $event->files()->with('user:id,name','fileable:id,name')->get();
        $resource_relations['payments'] = $event->payments()->with('user:id,name')->get();
        // $data_autofill['types'] = $types;
        $resource_relations['inventory'] =new Collection();
        foreach ($event->tasks as $task) {
            foreach ($task->inventory()->with('user:id,name')->get() as $inventory) {
                    $resource_relations['inventory']->push($inventory);
                }
            }
        // $data_autofill['suppliers'] = $suppliers;


        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
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
    public function update(UpdateEventRequest $request, Event $event)
    {
        
        $validated = $request->validated();;


        $event->name = $validated['name'];
        $event->address = $validated['address'];
        $dt_date_start = Carbon::parse($validated['date_start']);
        $dt_end_date = Carbon::parse($validated['date_start'])->addHours($validated['duration_hours']);;

        $date_start = $dt_date_start->format('Y-m-d H:i:s');
        $end_date = $dt_end_date->format('Y-m-d H:i:s');

        $event->date_start = $date_start;
        $event->date_end = $end_date;
        // return $event;


        $event->description = $validated['description'];
        if (isset($validated['job_id'])) {
            $event->job_id = $validated['job_id'];
        }
        if (isset($validated['deleted_at'])) {
            $event->deleted_at = Carbon::parse($validated['deleted_at'])->format('Y-m-d H:m:s');
        }
        $event->status = $request['status'];
        $event->created_by = Auth::id();

        $event->save();


        return Response::json([
            'message' => "Event updated!",
            'resource' => $event,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        $event->save();

        return Response::json([
            'message' => "Resource deleted!"
        ], 200);
    }
}

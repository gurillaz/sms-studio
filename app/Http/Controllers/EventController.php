<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Event;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Inventory;
use App\Job;
use App\Task;
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

        $resource_relations['tasks'] = $event->tasks()->with('user:id,name', 'employee:id,name', 'event:id,name', 'inventory:id,name')->get();

        $resource_relations['notes'] = $event->notes()->with('user:id,name', 'noteable:id,name')->get();
        $resource_relations['files'] = $event->files()->with('user:id,name', 'fileable:id,name')->get();
        $resource_relations['payments'] = $event->payments()->with('user:id,name')->get();

        //Te gjitha Eventet qe jane mbrenda periudhes kohere te eventit qe shikohet momentalisht-> i marrim id e  puntoreve dhe pajisjeve te puneve mbrenda ktyre eventeve dhe i ruajme ne array te vecanta, ne baze te puntoreve dhe pajisjve, me poshte me whereNotIn i marrim puntoret dhe pajisjet qe nuk kane kto id.
        //Iterimi behet kshtu EVENTET => TASK=>employee_id; TASK=>Inventory=>inventory_id
        $asigned_employees = new Collection();
        $asigned_inventory = new Collection();
        //Te gjitha datat e eventeve qe fillojne ose mbarojne mbrenda periudhes se eventit qe po tregohet
         Event::where('status', 'active')->where('date_end', '>', $resource->date_start)->where('date_start', '<', $resource->date_end)->get()->each(function ($ev) use ($asigned_employees, $asigned_inventory) {
            $ev->tasks->each(function ($tsk) use ($asigned_employees, $asigned_inventory) {
                $asigned_employees->push($tsk->employee_id);
                $tsk->inventory->each(function ($inv) use ($asigned_inventory) {
                    $asigned_inventory->push($inv->id);
                });
            });
        });

        //Puntoret e lire dhe evetet e lira
        $unasigned_employees = Employee::whereNotIn('id', $asigned_employees->toArray())->get(['id', 'name']);

        $unasigned_inventory = Inventory::whereNotIn('id', $asigned_inventory->toArray())->get(['id', 'name']);





        // $employees = Employee::where('status','active')->get();
        $data_autofill['employees'] = $unasigned_employees;
        $data_autofill['inventory'] = $unasigned_inventory;


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

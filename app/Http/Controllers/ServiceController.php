<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Inventory;
use App\Service;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Service::with(['tasks:id,name','offers:id,name','user:id,name'])->get();




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
        // $tasks = Task::where('status','template')->get();
        $tasks = Task::where('status','template')->with(['inventory:id,name'])->get();
        $inventory = Inventory::all('id','name');

        $data = [];


        $data['tasks'] = $tasks;
        $data['inventory'] = $inventory;


        return Response::json([
            'data_autofill' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {
        $validated = $request->validated();
        $service = new Service();


         $service->name = $validated['name'];
         $service->description = isset($validated['description']) ? $validated['description']:NULL;
         $service->price = $validated['price'];
         $service->status = 'active';

        $service->created_by = Auth::id();

        $service->save();

        if(isset($validated['tasks'])){
            $service_tasks = $validated['tasks'];

            $service->tasks()->sync($service_tasks);
        }
        
        // $task['inventory'] = $task->inventory()->get(['id','name']);


        return Response::json([
            'resource' => $service,
            'message' => "Service Added!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {


        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $service;
        $resource['created_by'] = $service->user()->first('name');
        $resource['class_name'] = $service->getMorphClass();

                

        $resource_relations['tasks'] = $service->tasks()->with('user:id,name','employee:id,name','event:id,name')->get();

        $resource_relations['notes'] = $service->notes()->with('user:id,name','noteable:id,name')->get();
        // $data_autofill['types'] = $types;
        $resource_relations['inventory'] =new Collection();
        foreach ($service->tasks as $task) {
            foreach ($task->inventory()->with('user:id,name')->get() as $inventory) {
                    $resource_relations['inventory']->push($inventory);
                }
            }


        $tasks =Task::where('status','template')->with(['inventory:id,name'])->get();
        $inventory = Inventory::all('id','name');

        $data_autofill['tasks'] = $tasks;
        $data_autofill['inventory'] = $inventory;



        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validated = $request->validated();


         $service->name = $validated['name'];
         $service->description = isset($validated['description']) ? $validated['description']:NULL;
         $service->price = $validated['price'];
         $service->status = 'active';

        $service->created_by = Auth::id();

        $service->save();

        if(isset($validated['tasks'])){
            $service_tasks = $validated['tasks'];

            $service->tasks()->sync($service_tasks);
        }
        $resource = $service;
        $resource['created_by'] = $service->user()->first('name');
        $resource['class_name'] = $service->getMorphClass();

                
        $resource_relations['notes'] = $service->notes()->get();
        $resource_relations['offers'] = $service->offers()->get();
        $resource_relations['tasks'] = $service->tasks()->with(['inventory:id,name'])->get();


        $tasks =Task::where('status','template')->with(['inventory:id,name'])->get();
        $inventory = Inventory::all('id','name');

        $data_autofill['tasks'] = $tasks;
        $data_autofill['inventory'] = $inventory;



        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill,
            'message' => "Service Updated!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}

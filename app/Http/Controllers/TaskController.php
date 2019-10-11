<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Event;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRatingRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Inventory;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Task::with(['event:id,name','employee:id,name','inventory:id,name','user:id,name'])->get();




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
        $inventory = Inventory::all(['id','name']);

        $data = [];


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
    public function store(CreateTaskRequest $request)
    {
        $validated = $request->validated();
        $task = new Task();


         $task->name = $validated['name'];
         $task->description = isset($validated['description']) ? $validated['description']:NULL;
         $task->payment_sum = $validated['payment_sum'];
         $task->status = $validated['status'];

        $task->created_by = Auth::id();

        $task->save();

        if(isset($validated['inventory'])){
            $task_inventory = $validated['inventory'];

            $task->inventory()->sync($task_inventory);
        }



        return Response::json([
            'new_resource_id' => $task->id,
            'message' => "Inventory Added!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        
        $inventory = Inventory::all(['id','name']);
        $employees = Employee::all(['id','name']);
        $events = Event::all(['id','name']);

        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $task;
        $resource['inventory'] = $task->inventory()->get()->pluck('id');
        $resource['created_by'] = $task->user()->first('name');
        $resource['class_name'] = $task->getMorphClass();

                
        $resource_relations['notes'] = $task->notes()->get();

        $data_autofill['inventory'] = $inventory;
        $data_autofill['employees'] = $employees;
        $data_autofill['events'] = $events;


        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();


         $task->name = $validated['name'];
         $task->description = isset($validated['description']) ? $validated['description']:NULL;
         $task->payment_sum = $validated['payment_sum'];
         $task->status = $validated['status'];

         
        if(isset($validated['employee_id'])){

            $task->employee_id = $validated['employee_id'];
        }
        if(isset($validated['event_id'])){

            $task->event_id = $validated['event_id'];
        }

        $task->created_by = Auth::id();

        $task->save();

        if(isset($validated['inventory'])){
            $task_inventory = $validated['inventory'];

            $task->inventory()->sync($task_inventory);
        }

        $task['inventory'] = $task->inventory()->get()->pluck('id');



        return Response::json([
            'resource' => $task,
            'message' => "Inventory updated!"
        ], 200);
    }
    public function update_rating(UpdateTaskRatingRequest $request, Task $task)
    {
        $validated = $request->validated();


         $task->rating = $validated['rating'];
            $task->save();



        return Response::json([
            'message' => "Rating saved!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}

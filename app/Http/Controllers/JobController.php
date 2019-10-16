<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\CreateEventRequest;
use App\Job;
use App\Offer;
use App\Client;
use App\Employee;
use App\Http\Requests\UpdateJobRequest;
use App\Task;
use Carbon\Carbon;
use Hamcrest\Arrays\IsArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Validator;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Job::all();

        $resorurces_map = $resources->map(function ($job) {

            $data = $job->only(['id', 'name', 'created_at', 'updated_at','price','discount','payment_status']);
            $data['created_by'] = $job->user->only(['name']);
            if(isset($job->client))
            $data['client'] = $job->client->only(['name']);
            else
            $data['client'] = '';
            if(isset($job->offer))
            
            $data['offer'] = $job->offer->only(['name']);
            else
            $data['offer'] = '';

            // $data['class_name'] = explode('\\', trim($job->getMorphClass()))[1];

            return $data;
        });


        return Response::json([
            'resources' => $resorurces_map
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data_autofill['clients'] = Client::all('name', 'id', 'city');
        $data_autofill['offers'] = Offer::with('services:id,name')->get();



        return Response::json([
            'data_autofill' => $data_autofill,
        ], 200);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJobRequest $request)
    {

        $validated = $request->validated();


        $job = new Job();

        $job->name = $validated['name'];
        $job->description = $validated['description'];
        $job->price = $validated['price'];
        $job->offer_id = $validated['offer_id'];
        $job->client_id = $validated['client_id'];
        $job->payment_status = "none";
        $job->status = "active";
        $job->created_by = Auth::id();

        $job->save();

        if(isset($validated['events'])){
            // return $validated['events'];
            $job_events = Event::withTrashed()->find($validated['events']);
            // return $job_events;
            if($job_events != null){
                foreach($job_events as $event){
                    $event->deleted_at = NULL;
                    $event->job_id = $job->id;
                    $event->status = 'active';
                    $event->save();
                }
            }
        }
        $offer_tasks = [];
        // $tasks = Task::where('service_id',)
        foreach($job->offer->services as $service){
            foreach($service->tasks as $task){
                        array_push($offer_tasks,$task);
            
            }   
        }
        // return $offer_tasks;
        foreach($offer_tasks as $task){
                    $task_clone = $task->replicate();
                    $task_clone->job_id = $job->id;
                    $task_clone->status = 'pending';
                    $task_clone->save();
                    $task_clone->inventory()->sync($task->inventory);
        }
        // return $job->tasks;
        return Response::json([
            'message' => "Job created!",
            'job' =>$job,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Job $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {

        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $job;
        $resource['created_by'] = $job->user()->first('name');
        $resource['class_name'] = $job->getMorphClass();

        $resource_relations['client'] = $job->client;
        $resource_relations['offer'] = $job->offer;
        
        $resource_relations['events'] = $job->events()->with('user:id,name','job.client:id,name')->get();
        $resource_relations['tasks'] = $job->tasks()->with('user:id,name','employee:id,name','event:id,name')->get();

        $resource_relations['tasks'] = $job->tasks()->with('user:id,name','employee:id,name','event:id,name')->get();
        $resource_relations['notes'] = $job->notes()->with('user:id,name','noteable:id,name')->get();
        $resource_relations['files'] = $job->files()->with('user:id,name','fileable:id,name')->get();
        $resource_relations['payments'] = $job->payments()->with('user:id,name')->get();


        $clients = Client::all(['id','name']);
        $employees = Employee::all(['id','name']);
        $offers = Offer::all(['id','name']);

        $data_autofill['clients'] = $clients;
        $data_autofill['employees'] = $employees;
        $data_autofill['offers'] = $offers;


        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Job $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Job $job
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobRequest $request, Job $job)
    {

        $validated = $request->validated();



        $job->name = $validated['name'];
        $job->description = $validated['description'];
        $job->price = $validated['price'];
        $job->offer_id = $validated['offer_id'];
        $job->client_id = $validated['client_id'];
        $job->created_by = Auth::id();

        $job->save();


        return Response::json([
            'message' => "Job updated!",
            'resource' =>$job,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }
}

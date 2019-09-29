<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\CreateEventRequest;
use App\Job;
use App\Offer;
use App\Client;
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
        $jobs = Job::all();

        //        $offers->map(function ($offer){
        //            $offer->services  = $offer->services()->get(['name','id'])->makeHidden('pivot');
        //
        //            $offer->created_by = $offer->user->name;
        //            return $offer;
        //        });


        return Response::json([
            'jobs' => $jobs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offers = Offer::all();

        $offers->map(function ($offer) {
            $offer->services  = $offer->services()->get(['name', 'id'])->makeHidden('pivot');

            $offer->created_by = $offer->user->name;
            return $offer;
        });

        $clients = Client::all('name', 'id', 'city');



        return Response::json([
            'offers' => $offers,
            'clients' => $clients
        ], 200);
    }




    /**
     * Store a added events create during creating new job
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addEvents(Request $request)
    {
        $validator   = Validator::make($request->all(), ['event_ids' => 'required'], ['required' => 'Duhet te kete te pakten nje event. Eventet nuk u shtuan!']);

        if ($validator->fails()) {
            return Response::json([
                'message' => "Eventet nuk u shtuan!",
                'errors' => ['event_ids' => 'Duhet te kete te pakten nje event. Eventet nuk u shtuan!']
            ], 400);
        }
        $events_ids = $request['event_ids'];
        $job_id = $request['job_id'];
        $job = Job::find($job_id);


        if (isset($events_ids) && is_array($events_ids) && count($events_ids) > 0) {

            $events = Event::withTrashed()->findMany($events_ids);

            if ($events != null && $job != null) {

                $events->each(function ($ev) use ($job) {
                    $ev->job_id = $job->id;
                    $ev->status = 'active';
                    $ev->deleted_at = null;
                    $ev->save();
                    // return;


                });
            } else {
                return Response::json([
                    'message' => "Eventet nuk u shtuan!",
                    'errors' => ['event_ids' => 'Gabim! Rifresko faqen!']
                ], 400);
            }
        } else {
            return Response::json([
                'message' => "Eventet nuk u shtuan!",
                'errors' => ['event_ids' => 'Gabim! Rifresko faqen!']
            ], 400);
        }

        // Sucsesss
        return Response::json([
            'message' => "Eventet u shtuan!",
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
        $request->validated();

        $validated = $request->validated();


        $job = new Job();

        $job->name = $validated['name'];
        $job->description = $validated['description'];
        $job->price = $validated['price'];
        $job->offer_id = $validated['offer_id'];
        $job->client_id = $validated['client_id'];
        $job->payment_status = "none";
        $job->status = "due";
        $job->created_by = Auth::id();

        $job->save();


        return Response::json([
            'message' => "Job created!",
            'job' =>$job,
             'class_name' => $job->getMorphClass()
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
        return Response::json([
            'job' => $job,
            'client'=>$job->client, 
            'offer'=>$job->offer, 
            'events'=>$job->events, 
            'files' => $job->files,
            'payments' => $job->payments,
            'notes' => $job->notes,
            'class_name' => $job->getMorphClass()
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
    public function update(Request $request, Job $job)
    {
        //
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

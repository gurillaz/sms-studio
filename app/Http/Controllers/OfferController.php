<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Offer;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

//        $offers = Offer::all()->each(function ($offer) {
//            return $offer->services;
//        });
        $offers = Offer::with('services:id,name','user:id,name')->get();




        return Response::json([
            'resources' => $offers
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
                $services = Service::all('id','name','price');
        
                $data = [];
        
        
                $data['services'] = $services;
        
        
                return Response::json([
                    'data_autofill' => $data,
                ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOfferRequest $request)
    {
        $validated = $request->validated();
        $offer = new Offer();
         $offer->name = $validated['name'];
         $offer->description = isset($validated['description']) ? $validated['description']:NULL;
         $offer->price = $validated['price'];
         $offer->status = 'active';
        $offer->created_by = Auth::id();
        $offer->save();
        if(isset($validated['services'])){
            $offer_services = $validated['services'];
            $offer->services()->sync($offer_services);
        }
        
        // $task['inventory'] = $task->inventory()->get(['id','name']);
        return Response::json([
            'resource' => $offer,
            'message' => "Service Added!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $offer;
        $resource['created_by'] = $offer->user()->first('name');
        $resource['class_name'] = $offer->getMorphClass();

                

        $resource_relations['services'] = $offer->services()->with('user:id,name')->get();

        $resource_relations['notes'] = $offer->notes()->with('user:id,name','noteable:id,name')->get();
        // $data_autofill['types'] = $types;


        $services = Service::where('status','active')->get();

        $data_autofill['services'] = $services;



        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $validated = $request->validated();
         $offer->name = $validated['name'];
         $offer->description = isset($validated['description']) ? $validated['description']:NULL;
         $offer->price = $validated['price'];
         $offer->status = 'active';
        $offer->created_by = Auth::id();
        $offer->save();
        if(isset($validated['services'])){
            $offer_services = $validated['services'];
            $offer->services()->sync($offer_services);
        }
        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $offer;
        $resource['created_by'] = $offer->user()->first('name');
        $resource['class_name'] = $offer->getMorphClass();

                

        $resource_relations['services'] = $offer->services()->with('user:id,name')->get();

        $resource_relations['notes'] = $offer->notes()->with('user:id,name','noteable:id,name')->get();
        // $data_autofill['types'] = $types;


        $services = Service::where('status','active')->get();

        $data_autofill['services'] = $services;
        
        
        // $task['inventory'] = $task->inventory()->get(['id','name']);
        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill,
            'message' => "Service Added!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}

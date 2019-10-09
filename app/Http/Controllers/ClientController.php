<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clients = Client::all();


        return Response::json([
            'resources' => $clients
        ], 200);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = Client::all()->pluck('city');
     
        $data_autofill['cities'] = $cities;
        // $data_autofill['suppliers'] = $suppliers;


        return Response::json([
            'data_autofill' => $data_autofill
        ], 200);

    }

    /**
     * Validate CreateClient request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function checkCreateClientValidation(CreateClientRequest $request){


         $request->validated();


         return Response::json([
            'message' => "Validated!",
            'data' => "",
        ], 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateClientRequest $request)
    {
        $validated = $request->validated();

//        return $validated;
        $client = new Client();

        $client->name = $validated['name'];
        $client->city = $validated['city'];
        $client->address = $validated['address'];
        $client->phone = $validated['phone'];
        $client->email = $validated['email'];
        $client->created_by = \Auth::id();

        $client->save();


        return Response::json([
            'message' => "Client created!",
            'client' => ['id'=>$client->id,'name'=>$client->name,'city'=>$client->city],
        ], 200);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Client $client)
    {
        
        $cities = Client::all()->pluck('city');
        // $suppliers = Inventory::all()->pluck('supplier');

        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $client;
        $resource['created_by'] = $client->user()->first('name');
        $resource['class_name'] = $client->getMorphClass();

                
        $resource_relations['notes'] = $client->notes()->get();
        $resource_relations['files'] = $client->files()->get();
        $resource_relations['payments'] = $client->payments()->get();

        $data_autofill['cities'] = $cities;
        // $data_autofill['suppliers'] = $suppliers;


        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);

        // return Response::json([
        //     'client' => $client,
        //     'files' => $client->files,
        //     'payments' => $client->payments,
        //     'notes' => $client->notes,
        //     'class_name' => $client->getMorphClass()
        // ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
//        return "OK";
        $validated = $request->validated();

        $client->name = $validated['name'];
        $client->city = $validated['city'];
        $client->address = $validated['address'];
        $client->phone = $validated['phone'];
        $client->email = $validated['email'];

        $client->save();



        $resource = [];
   


        $resource = $client;
        $resource['created_by'] = $client->user()->first('name');
        $resource['class_name'] = $client->getMorphClass();



        return Response::json([
            'resource' => $resource,

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client)
    {


        // $client->delete();
        // $client->save();

        return Response::json([
            'message' => "Client deleted!",
        ], 200);
    }

}

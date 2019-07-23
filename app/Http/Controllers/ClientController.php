<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $deleted_clients = Client::onlyTrashed()->get();

        return view('client.clients',[
            'clients'=>$clients,
            'deleted_clients'=>$deleted_clients
            ]);
        \Session::push('page','client');

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        \Session::push('page','client');
        \Session::push('section','add_client_section');

        return redirect()->to('client'.'#add_client_section');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        $validated = $request->validated();

//        return $validated;
        $client = new Client();

        $client->name = $validated['name'];
        $client->city= $validated['city'];
        $client->address= $validated['address'];
        $client->phone= $validated['phone'];
        $client->email= $validated['email'];
        $client->created_by= \Auth::id();

        $client->save();


        return view('client.client', compact('client',$client));







    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        if($client->deleted_at != null){
            return abort(404);
        }

        return view('client.client',compact('client',$client));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
//        return "OK";
        $validated = $request->validated();

        $client->name = $validated['name'];
        $client->city= $validated['city'];
        $client->address= $validated['address'];
        $client->phone= $validated['phone'];
        $client->email= $validated['email'];

        $client->save();

        return view('client.client', compact('client',$client));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if(\request()->ajax()){


            $client->delete();
            $client->save();

            return ['status'=>'success','message'=>'Client deleted'];

        }
        $client->delete();
        $client->save();

        return redirect('/client')->with('success','Client deleted');
    }

}

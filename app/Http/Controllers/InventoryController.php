<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all();

        return Response::json([
            'data' => $inventories
        ], 200);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



        $types = Inventory::all()->pluck('type');
        $suppliers = Inventory::all()->pluck('supplier');

        $data = [];


        $data['types'] = $types;
        $data['suppliers'] = $suppliers;


        return Response::json([
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInventoryRequest $request)
    {
        $validated = $request->validated();
        $inventory = new Inventory();


         $inventory->name = $validated['name'];
         $inventory->type = $validated['type'];
         $inventory->purchase_date = isset($validated['purchase_date']) ? $validated['purchase_date']:NULL;
         $inventory->supplier = isset($validated['supplier']) ? $validated['supplier']:NULL;
         $inventory->price = isset($validated['price']) ? $validated['price']:NULL;
         $inventory->serial = isset($validated['serial']) ? $validated['serial']:NULL;
         $inventory->description = isset($validated['description']) ? $validated['description']:NULL;
         $inventory->status = $validated['status'];


        $inventory->created_by = Auth::id();

        $inventory->save();


        return Response::json([
            'new_inventory_id' => $inventory->id,
            'message' => "Inventory Added!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        


        $types = Inventory::all()->pluck('type');
        $suppliers = Inventory::all()->pluck('supplier');

        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $inventory;
        $resource['created_by'] = $inventory->user()->first('name');
        $resource['class_name'] = $inventory->getMorphClass();

                
        $resource_relations['notes'] = $inventory->notes()->get();
        $resource_relations['files'] = $inventory->files()->get();
        $resource_relations['payments'] = $inventory->payments()->get();

        $data_autofill['types'] = $types;
        $data_autofill['suppliers'] = $suppliers;


        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        $validated = $request->validated();


         $inventory->name = $validated['name'];
         $inventory->type = $validated['type'];
         $inventory->purchase_date = isset($validated['purchase_date']) ? $validated['purchase_date']:NULL;
         $inventory->supplier = isset($validated['supplier']) ? $validated['supplier']:NULL;
         $inventory->price = isset($validated['price']) ? $validated['price']:NULL;
         $inventory->serial = isset($validated['serial']) ? $validated['serial']:NULL;
         $inventory->description = isset($validated['description']) ? $validated['description']:NULL;
         $inventory->status = $validated['status'];


        $inventory->created_by = Auth::id();

        $inventory->save();

        $resource = [];



        $resource = $inventory;
        $resource['created_by'] = $inventory->user()->first('name');
        $resource['class_name'] = $inventory->getMorphClass();



        return Response::json([
            'resource' => $resource,
            'message' => "Changed data is saved!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Category;
use App\Client;
use App\Employee;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Inventory;
use App\Job;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        $payments_map = $payments->map(function ($payment) {

            // $data = $payment->only(['id', 'name', 'created_at', 'updated_at']);
            $data = $payment;
            $data['created_by'] = $payment->user->only('name');
            if(isset($payment->paymentable)){
            $data['belongs_to'] = $payment->paymentable->only(['id', 'name']);
     
            $data['model'] = explode('\\', trim($payment->paymentable_type))[1];
        }else{
            $data['belongs_to'] = '';
     
            $data['model'] = '';
        }
            return $data;
        });


        return Response::json([
            'payments' => $payments_map
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all()->map(function($resource){
            $resource_data = [];
            $resource_data['id'] = $resource->id;
            $resource_data['name'] = $resource->name;
            $resource_data['model'] = explode('\\', trim($resource->getMorphClass()))[1];
            return $resource_data;
        });
        $jobs = Job::all()->map(function($resource){
            $resource_data = [];
            $resource_data['id'] = $resource->id;
            $resource_data['name'] = $resource->name;
            $resource_data['client'] = $resource->client->name;
            $resource_data['model'] = explode('\\', trim($resource->getMorphClass()))[1];
            return $resource_data;
        });
        $employess = Employee::all()->map(function($resource){
            $resource_data = [];
            $resource_data['id'] = $resource->id;
            $resource_data['name'] = $resource->name;
            $resource_data['model'] = explode('\\', trim($resource->getMorphClass()))[1];
            return $resource_data;
        });
        $inventory = Inventory::all()->map(function($resource){
            $resource_data = [];
            $resource_data['id'] = $resource->id;
            $resource_data['name'] = $resource->name;
            $resource_data['model'] = explode('\\', trim($resource->getMorphClass()))[1];
            return $resource_data;
        });



        $categories = Payment::all()->pluck('category');

        $data = [];


        // $data['notes'] = $payment->notes;
        $data['for_in'] = $clients->merge($jobs);
        $data['for_out'] = $employess->merge($inventory);
        $data['categories'] = $categories;
 

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
    public function store(CreatePaymentRequest $request)
    {
        $validated = $request->validated();
        $payment = new Payment();

        $payment->name = $validated['name'];
        $payment->amount = $validated['amount'];
        $payment->from = $validated['from'];
        $payment->to = $validated['to'];
        $payment->type = $validated['type'];
        $payment->status = $validated['status'];;
        $payment->description = $validated['description'];
        if (isset($validated['category'])) {
            $payment->category = $validated['category'];
        }
        if (isset($validated['paymentable_id'])) {

            $payment->paymentable_id = $validated['paymentable_id'];
        }
        if (isset($validated['paymentable_type'])) {

            $payment->paymentable_type = $validated['paymentable_type'];
        }

        $payment->created_by = Auth::id();

        $payment->save();


        return Response::json([
            'payment' => $payment,
            'message' => "Payment Added!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $data = [];

        $data = $payment->only('id', 'name', 'description', 'category', 'from', 'to', 'amount', 'type', 'created_at', 'updated_at');
        $data['created_by'] = $payment->user->only('name');
        if($payment->paymentable != null){
        $data['belongs_to'] = $payment->paymentable->only(['id', 'name']);
        $data['model'] = explode('\\', trim($payment->paymentable_type))[1];
    }
    else{
        $data['belongs_to'] = '';
        $data['model'] = '';
    }
        $data['class_name'] = $payment->getMorphClass();
        $data['notes'] = $payment->notes;
        $data['files'] = $payment->files;

        return Response::json([
            'payment' => $data,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $validated = $request->validated();


        $payment->name = $validated['name'];
        $payment->amount = $validated['amount'];
        $payment->from = $validated['from'];
        $payment->to = $validated['to'];
        $payment->type = $validated['type'];
        $payment->description = $validated['description'];


        $payment->created_by = Auth::id();

        $payment->save();

        $data = [];

        $data = $payment->only('id', 'name', 'description', 'from', 'to', 'amount', 'type', 'created_at', 'updated_at');
        $data['created_by'] = $payment->user->only('name');

        if($payment->paymentable != null){
            $data['belongs_to'] = $payment->paymentable->only(['id', 'name']);
            $data['model'] = explode('\\', trim($payment->paymentable_type))[1];
        }
        else{
            $data['belongs_to'] = '';
            $data['model'] = '';
        }

        $data['class_name'] = $payment->getMorphClass();
        $data['notes'] = $payment->notes;
        $data['files'] = $payment->files;


        return Response::json([
            'payment' => $data,
            'message' => "Payment updated!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        $payment->save();

        return Response::json([
            'message' => "Payment Deleted!"
        ], 200);
    }

    public function destroyAjax($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->delete();
        $payment->save();
    }
}

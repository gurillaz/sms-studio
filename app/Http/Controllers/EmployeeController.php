<?php

namespace App\Http\Controllers;

use App\Employee;
use App\File;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeAccessInfoRequest;
use App\Http\Requests\UpdateEmployeeBasicInfoRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeWorkInfoRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Storage as Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        $deleted_employees = Employee::all()->where('deleted_at', '!=', null);

        return Response::json([
            'data' => $employees
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $validated = $request->validated();

        $employee = new Employee();

        $employee->name = $validated['name'];
        $employee->personal_id = $validated['personal_id'];
        $employee->address = $validated['address'];
        $employee->email = $validated['email'];
        $employee->phone = $validated['phone'];
        $employee->employee_type = $validated['employee_type'];
        $employee->position = $validated['position'];
        $employee->salary_type = $validated['salary_type'];
        $employee->salary_amount = $validated['salary_amount'];
        $employee->role = $validated['role'];
        $employee->password =  Hash::make($validated['password']);

        $employee->status = 'change_password';
        $employee->created_by = \Auth::id();



        //Check if salary type is day month or hour
        if (!in_array($validated['salary_type'], ['hour', 'day', 'week', 'month', 'undefined'])) {
            return Response::json([
                'errors' => ['salary_type' => 'Zgjidh nga opsionet!']
            ], 422);
        }
        //Check if employee type is regualr or part_time
        if (!in_array($validated['employee_type'], ['regular', 'part_time'])) {
            return Response::json([
                'errors' => ['employee_type' => 'Zgjidh nga opsionet!']
            ], 422);
        }
        //Check if employee role is admin or employee
        if (!in_array($validated['role'], ['admin', 'employee'])) {
            return Response::json([
                'errors' => ['role' => 'Zgjidh nga opsionet!']
            ], 422);
        }


        $employee->save();

        /* 
        if ($request->file('profile_photo') !== null) {



                $profile_photo_file = new File();

                $profile_photo_file->name = "META_Profile_Photo";
                $profile_photo_file->description = $employee->name . " profile photo HIDDEN";
                $profile_photo_file->meta_name = "profile_photo";


                $profile_photo_file->fileable_id = $employee->id;
                $profile_photo_file->fileable_type = "App\Employee";


                $profile_photo_file->created_by = \Auth::id();

                $fileName = 'META_Profile_Photo-' . str_replace(' ', '_', $request->file('profile_photo')->getClientOriginalName());


                Storage::putFileAs('public/uploads', $request->file('profile_photo'), $fileName);


                $profile_photo_file->file = basename($fileName);


                $employee->all_files->save($profile_photo_file);
            }

*/
        return Response::json([
            'message' => "New employee saved!",
            'new_employee_id' => $employee->id
        ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

        // $types = Inventory::all()->pluck('type');
        // $suppliers = Inventory::all()->pluck('supplier');

        $resource = [];
        $resource_relations = [];
        $data_autofill = [];


        $resource = $employee;
        $resource['created_by'] = $employee->user()->first('name');
        $resource['class_name'] = $employee->getMorphClass();


        $resource_relations['notes'] = $employee->notes()->with('user:id,name','noteable:id,name')->get();
        $resource_relations['files'] = $employee->files()->with('user:id,name','fileable:id,name')->get();
        $resource_relations['payments'] = $employee->payments()->with('user:id,name')->get();
        $resource_relations['tasks'] = $employee->tasks()->with('user:id,name','employee:id,name','event:id,name')->get();
        $resource_relations['inventory'] =new Collection();
        foreach ($employee->tasks as $task) {
            foreach ($task->inventory()->with('user:id,name')->get() as $inventory) {
                    $resource_relations['inventory']->push($inventory);
                }
            }
        $resource_relations['jobs'] =new Collection();
        foreach ($employee->tasks as $task) {
            foreach ($task->job()->with('user:id,name','client:id,name','offer:id,name')->get() as $job) {
                    $resource_relations['jobs']->push($job);
                }
            }
        $resource_relations['events'] =new Collection();
        foreach ($resource_relations['jobs'] as $job) {
            $resource_relations['jobs']->push($job);
                foreach ($job->events()->with('user:id,name','job.client:id,name')->get() as $event) {
                    $resource_relations['events']->push($event);

                }
            }

        // $data_autofill['types'] = $types;
        // $data_autofill['suppliers'] = $suppliers;


        return Response::json([
            'resource' => $resource,
            'resource_relations' => $resource_relations,
            'data_autofill' => $data_autofill
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    { }
    public function update_basic_info(UpdateEmployeeBasicInfoRequest $request, Employee $employee)
    {
        
        $validated = $request->validated();


        $employee->name = $validated['name'];
        $employee->personal_id = $validated['personal_id'];
        $employee->address = $validated['address'];
        $employee->email = $validated['email'];
        $employee->phone = $validated['phone'];


        $employee->created_by = \Auth::id();


        $employee->save();

        return Response::json([
            'message' => "Changet data is saved!",
            'resource' => $employee
        ], 200);
    }
    public function update_work_info(UpdateEmployeeWorkInfoRequest $request, Employee $employee)
    {
        $validated = $request->validated();


        $employee->employee_type = $validated['employee_type'];
        $employee->position = $validated['position'];
        $employee->salary_type = $validated['salary_type'];
        $employee->salary_amount = $validated['salary_amount'];

        $employee->created_by = \Auth::id();



        //Check if salary type is day month or hour
        if (!in_array($validated['salary_type'], ['hour', 'day', 'week', 'month', 'undefined'])) {
            return Response::json([
                'errors' => ['salary_type' => 'Zgjidh nga opsionet!']
            ], 422);
        }
        //Check if employee type is regualr or part_time
        if (!in_array($validated['employee_type'], ['regular', 'part_time'])) {
            return Response::json([
                'errors' => ['employee_type' => 'Zgjidh nga opsionet!']
            ], 422);
        }



        $employee->save();


        return Response::json([
            'message' => "Changet data is saved!",
            'resource' => $employee
        ], 200);
    }
    public function update_access_info(UpdateEmployeeAccessInfoRequest $request, Employee $employee)
    {
        $validated = $request->validated();
        if (!in_array($validated['role'], ['admin', 'employee'])) {
            return Response::json([
                'errors' => ['role' => 'Zgjidh nga opsionet!']
            ], 422);
        }

        $employee->role = $validated['role'];
        $employee->password =  Hash::make($validated['password']);

        $employee->created_by = \Auth::id();

        //Check if employee role is admin or employee



        $employee->save();
        return Response::json([
            'message' => "Changet data is saved!",
            'resource' => $employee
        ], 200);

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if (\request()->ajax()) {

            $employee->delete();
            $employee->save();

            return ['status' => 'success', 'message' => 'Employee deleted'];
        }

        $employee->delete();
        $employee->save();

        return redirect('/client')->with('success', 'Employee deleted');
    }
}

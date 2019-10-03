<?php

namespace App\Http\Controllers;

use App\Employee;
use App\File;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
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
        if (!in_array($validated['salary_type'], ['hour', 'day','week','month', 'undefined'])) {
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
        return Response::json([
            'employee' => $employee,
            'files' => $employee->files,
            'payments' => $employee->payments,
            'notes' => $employee->notes,
            'class_name' => $employee->getMorphClass()
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
    {


        $validated = $request->validated();


        $employee->name = $validated['name'];
        $employee->address = $validated['address'];
        $employee->phone = $validated['phone'];
        $employee->position = $validated['position'];

        //Check if salary type is day month or hour
        if (!in_array($validated['salary_type'], ['day', 'month', 'hour'])) {
            return exit("Gabim! Rifresko faqen");
        }
        //        return "OKsss";
        $employee->salary_type = $validated['salary_type'];
        $employee->salary_amount = $validated['salary_amount'];
        $employee->status = 'active';
        $employee->created_by = \Auth::id();

        $employee->save();

        //if profile wasn't requested to be updated
        if ($request->file('profile_photo') !== null) {

            $profile_photo_file = $employee->all_files->where('meta_name', '===', 'profile_photo')->first();
            //If profile photo already exists
            if ($profile_photo_file !== null) {
                $fileName = 'META_Profile_Photo-' . str_replace(' ', '_', $request->file('profile_photo')->getClientOriginalName());


                Storage::putFileAs('public/uploads', $request->file('profile_photo'), $fileName);


                $profile_photo_file->file = basename($fileName);


                $profile_photo_file->save();
            } //If profile photo doesn't exists, create new file, with meta_name = profile_photo
            else {

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
        }


        return redirect('/employee/' . $employee->id)->with(compact('employee', $employee));
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

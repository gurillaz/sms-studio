<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;

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

        return view('employee.employees', [
            'employees' => $employees,
            'deleted_employees' => $deleted_employees
        ]);
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
        $employee->address = $validated['address'];
        $employee->phone = $validated['phone'];
        $employee->position = $validated['position'];

        //Check if salary type is day month or hour
        if (!in_array($validated['salary_type'], ['day', 'month', 'hour'])) {
            return exit("Gabim! Rifresko faqen");
        }

        $employee->salary_type = $validated['salary_type'];
        $employee->salary_amount = $validated['salary_month'];
        $employee->status = 'active';
        $employee->created_by = \Auth::id();

        $employee->save();

//        return $employee;
        return view('employee.employee', compact('employee', $employee));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if ($employee->deleted_at != null) {
            return abort(404);
        }

        return view('employee.employee', compact('employee', $employee));
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


        return view('employee.employee', compact('employee', $employee));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if(\request()->ajax()){

            $employee->delete();
            $employee->save();

            return ['status' => 'success', 'message' => 'Employee deleted'];

        }

        $employee->delete();
        $employee->save();

        return redirect('/client')->with('success', 'Employee deleted');
    }


}

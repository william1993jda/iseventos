<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDependent;
use Illuminate\Http\Request;

class EmployeeDependentController extends Controller
{
    public function index(Employee $employee, Request $request)
    {
        $dependents = $employee->dependents()->paginate(10);

        return view('employees.dependents.index', compact('employee', 'dependents'));
    }

    public function create(Employee $employee)
    {
        $dependent = new EmployeeDependent();


        return view('employees.dependents.form', compact('employee', 'dependent'));
    }

    public function store(Employee $employee, Request $request)
    {
        $employee->dependents()->create($request->all());

        return redirect()->route('employees.dependents.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeDependent $dependent)
    {

        return view('employees.dependents.form', compact('employee', 'dependent'));
    }

    public function update(Employee $employee, EmployeeDependent $dependent, Request $request)
    {
        $dependent->update($request->all());

        return redirect()->route('employees.dependents.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeDependent $dependent)
    {
        $dependent->delete();

        return redirect()->route('employees.dependents.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeDependent $dependent)
    {
        $showMode = true;

        return view('employees.dependents.form', compact('employee', 'dependent', 'showMode'));
    }
}

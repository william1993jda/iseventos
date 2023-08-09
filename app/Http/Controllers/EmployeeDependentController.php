<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeDependentRequest;
use App\Models\Employee;
use App\Models\EmployeeDependent;
use Illuminate\Http\Request;

class EmployeeDependentController extends Controller
{
    public function index(Employee $employee, Request $request)
    {
        $dependents = $employee->dependents()->orderBy('name', 'ASC')->paginate(10);

        return view('employees.dependents.index', compact('employee', 'dependents'));
    }

    public function create(Employee $employee)
    {
        $dependent = new EmployeeDependent();

        return view('employees.dependents.form', compact('employee', 'dependent'));
    }

    public function store(Employee $employee, EmployeeDependentRequest $request)
    {
        $employee->dependents()->create($request->validated());

        return redirect()->route('employees.dependents.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeDependent $dependent, $showMode = false)
    {

        return view('employees.dependents.form', compact('employee', 'dependent', 'showMode'));
    }

    public function update(Employee $employee, EmployeeDependent $dependent, EmployeeDependentRequest $request)
    {
        $dependent->update($request->validated());

        return redirect()->route('employees.dependents.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeDependent $dependent)
    {
        $dependent->delete();

        return redirect()->route('employees.dependents.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeDependent $dependent)
    {
        return $this->edit($employee, $dependent, true);
    }
}

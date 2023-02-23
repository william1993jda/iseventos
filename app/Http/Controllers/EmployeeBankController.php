<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeBank;
use Illuminate\Http\Request;

class EmployeeBankController extends Controller
{
    public function index(Employee $employee, Request $request)
    {
        $banks = $employee->banks()->paginate(10);

        return view('employees.banks.index', compact('employee', 'banks'));
    }

    public function create(Employee $employee)
    {
        $bank = new EmployeeBank();
        $types = EmployeeBank::TYPES;

        return view('employees.banks.form', compact('employee', 'bank', 'types'));
    }

    public function store(Employee $employee, Request $request)
    {
        $employee->banks()->create($request->all());

        return redirect()->route('employees.banks.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeBank $bank)
    {
        $types = EmployeeBank::TYPES;

        return view('employees.banks.form', compact('employee', 'bank', 'types'));
    }

    public function update(Employee $employee, EmployeeBank $bank, Request $request)
    {
        $bank->update($request->all());

        return redirect()->route('employees.banks.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeBank $bank)
    {
        $bank->delete();

        return redirect()->route('employees.banks.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeBank $bank)
    {
        $showMode = true;
        $types = EmployeeBank::TYPES;


        return view('employees.banks.form', compact('employee', 'bank', 'showMode', 'types'));
    }
}

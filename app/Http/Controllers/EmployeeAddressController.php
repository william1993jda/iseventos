<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use Illuminate\Http\Request;

class EmployeeAddressController extends Controller
{
    public function index(Employee $employee, Request $request)
    {
        $addresses = $employee->addresses()->paginate(10);

        return view('employees.addresses.index', compact('employee', 'addresses'));
    }

    public function create(Employee $employee)
    {
        $address = new EmployeeAddress();
        $states = EmployeeAddress::STATES;

        return view('employees.addresses.form', compact('employee', 'address', 'states'));
    }

    public function store(Employee $employee, Request $request)
    {
        $employee->addresses()->create($request->all());

        return redirect()->route('employees.addresses.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeAddress $address)
    {
        $states = EmployeeAddress::STATES;

        return view('employees.addresses.form', compact('employee', 'address', 'states'));
    }

    public function update(Employee $employee, EmployeeAddress $address, Request $request)
    {
        $address->update($request->all());

        return redirect()->route('employees.addresses.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeAddress $address)
    {
        $address->delete();

        return redirect()->route('employees.addresses.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeAddress $address)
    {
        $showMode = true;
        $states = EmployeeAddress::STATES;

        return view('employees.addresses.form', compact('employee', 'address', 'showMode', 'states'));
    }
}

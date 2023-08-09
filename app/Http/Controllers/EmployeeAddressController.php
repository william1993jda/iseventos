<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeAddressRequest;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use Illuminate\Http\Request;

class EmployeeAddressController extends Controller
{
    public function index(Employee $employee, Request $request)
    {
        $addresses = $employee->addresses()->orderBy('name', 'ASC')->paginate(10);

        return view('employees.addresses.index', compact('employee', 'addresses'));
    }

    public function create(Employee $employee)
    {
        $address = new EmployeeAddress();
        $states = EmployeeAddress::STATES;

        return view('employees.addresses.form', compact('employee', 'address', 'states'));
    }

    public function store(Employee $employee, EmployeeAddressRequest $request)
    {
        $employee->addresses()->create($request->validated());

        return redirect()->route('employees.addresses.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeAddress $address, $showMode = false)
    {
        $states = EmployeeAddress::STATES;

        return view('employees.addresses.form', compact('employee', 'address', 'states', 'showMode'));
    }

    public function update(Employee $employee, EmployeeAddress $address, EmployeeAddressRequest $request)
    {
        $address->update($request->validated());

        return redirect()->route('employees.addresses.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeAddress $address)
    {
        $address->delete();

        return redirect()->route('employees.addresses.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeAddress $address)
    {
        return $this->edit($employee, $address, true);
    }
}

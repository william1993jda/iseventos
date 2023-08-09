<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeContactRequest;
use App\Models\Employee;
use App\Models\EmployeeContact;
use Illuminate\Http\Request;

class EmployeeContactController extends Controller
{
    public function index(Employee $employee, Request $request)
    {
        $contacts = $employee->contacts()->orderBy('name', 'ASC')->paginate(10);

        return view('employees.contacts.index', compact('employee', 'contacts'));
    }

    public function create(Employee $employee)
    {
        $contact = new EmployeeContact();

        return view('employees.contacts.form', compact('employee', 'contact'));
    }

    public function store(Employee $employee, EmployeeContactRequest $request)
    {
        $employee->contacts()->create($request->validated());

        return redirect()->route('employees.contacts.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeContact $contact, $showMode = false)
    {
        return view('employees.contacts.form', compact('employee', 'contact', 'showMode'));
    }

    public function update(Employee $employee, EmployeeContact $contact, EmployeeContactRequest $request)
    {
        $contact->update($request->validated());

        return redirect()->route('employees.contacts.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeContact $contact)
    {
        $contact->delete();

        return redirect()->route('employees.contacts.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeContact $contact)
    {
        return $this->edit($employee, $contact, true);
    }
}

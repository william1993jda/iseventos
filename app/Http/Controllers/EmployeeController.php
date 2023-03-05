<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $employees = User::where('name', 'like', '%' . $params['query'] . '%')
                ->orWhere('email', 'like', '%' . $params['query'] . '%')
                ->join('employees', 'users.id', '=', 'employees.user_id')
                ->paginate(10);

            return view('employees.index', compact('employees', 'query'));
        }

        $employees = User::join('employees', 'users.id', '=', 'employees.user_id')->paginate(10);

        return view('employees.index', compact('employees', 'query'));
    }

    public function create()
    {
        $employee = new Employee();

        return view('employees.form', compact('employee'));
    }

    public function store(EmployeeRequest $request)
    {
        $params = $request->validated();

        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => '12345678',
        ]);

        $params['user_id'] = $user->id;

        Employee::create($params);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee, $showMode = false)
    {
        $user = User::find($employee->user_id);
        $employee->name = $user->name;
        $employee->email = $user->email;

        return view('employees.form', compact('employee', 'showMode'));
    }

    public function update(Employee $employee, EmployeeRequest $request)
    {
        $params = $request->validated();

        $employee->fill($params);
        $employee->save();

        $user = User::find($employee->user_id);
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->save();

        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $user = $employee->user;
        $employee->delete();
        $user->delete();

        return redirect()->route('employees.index');
    }

    public function show(Employee $employee)
    {
        return $this->edit($employee, true);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $employees = User::where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->whereNull('employees.deleted_at')
                ->join('employees', 'users.id', '=', 'employees.user_id')
                ->orderBy('users.name', 'ASC')
                ->paginate(10);

            return view('employees.index', compact('employees', 'query'));
        }

        $employees = User::join('employees', 'users.id', '=', 'employees.user_id')->whereNull('employees.deleted_at')->orderBy('users.name', 'ASC')->paginate(10);

        return view('employees.index', compact('employees', 'query'));
    }

    public function create()
    {
        $employee = new Employee();
        $roles = Employee::ROLES;

        return view('employees.form', compact('employee', 'roles'));
    }

    public function store(EmployeeRequest $request)
    {
        $params = $request->validated();

        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make('12345678'),
        ]);

        $params['user_id'] = $user->id;

        Employee::create($params);

        $user->syncRoles($params['role']);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee, $showMode = false)
    {
        $user = User::find($employee->user_id);
        $employee->name = $user->name;
        $employee->email = $user->email;
        $roles = Employee::ROLES;
        $employee->role = $user->getRoleNames()->first();

        return view('employees.form', compact('employee', 'roles', 'showMode'));
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

        $user->syncRoles($params['role']);

        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index');
    }

    public function show(Employee $employee)
    {
        return $this->edit($employee, true);
    }
}

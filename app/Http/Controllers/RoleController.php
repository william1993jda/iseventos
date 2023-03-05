<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($params) {
            $roles = Role::where('name', 'like', '%' . $params['query'] . '%')
                ->paginate(10);

            return view('roles.index', compact('users', 'query'));
        }

        $roles = Role::paginate(10);

        return view('roles.index', compact('roles', 'query'));
    }

    public function permissions(Role $role)
    {
        $permissions = Permission::all();

        $arPermissions = [];

        foreach ($permissions as $permission) {
            $name = explode('.', $permission->name);

            if (count($name) == 2) {
                if (!isset($arPermissions[$name[0]])) {
                    $arPermissions[$name[0]] = [];
                }

                array_push($arPermissions[$name[0]], $permission);
            }

            if (count($name) == 3) {
                if (!isset($arPermissions[$name[0] . '.' . $name[1]])) {
                    $arPermissions[$name[0] . '.' . $name[1]] = [];
                }

                array_push($arPermissions[$name[0] . '.' . $name[1]], $permission);
            }

            if (count($name) == 4) {
                if (!isset($arPermissions[$name[0] . '.' . $name[1] . '.' . $name[2]])) {
                    $arPermissions[$name[0] . '.' . $name[1] . '.' . $name[2]] = [];
                }

                array_push($arPermissions[$name[0] . '.' . $name[1] . '.' . $name[2]], $permission);
            }
        }

        $permissions = collect($arPermissions);

        // dd($permissions);

        return view('roles.permissions', compact('role', 'permissions'));
    }

    public function permissionsStore(Role $role, Request $request)
    {
        $params = $request->all();

        if ($params) {
            $role->syncPermissions($params['permission_id']);

            return redirect()->route('roles.index');
        }
    }

    // public function create()
    // {
    //     $user = new User();

    //     return view('roles.form')->with('user', $user);
    // }

    // public function store(Request $request)
    // {
    //     $params = $request->all();

    //     if ($params) {
    //         $user = new User();
    //         $user->name = $params['name'];
    //         $user->email = $params['email'];
    //         $user->password = Hash::make($params['password']);
    //         $user->save();

    //         return redirect()->route('roles.index');
    //     }
    // }

    // public function edit($id)
    // {
    //     $user = User::find($id);

    //     return view('roles.form', compact('user'));
    // }

    // public function update($id, Request $request)
    // {
    //     $params = $request->all();

    //     if ($params) {
    //         $user = User::find($id);
    //         $user->fill($params);
    //         $user->save();

    //         return redirect()->route('roles.index');
    //     }
    // }

    // public function destroy($id)
    // {
    //     $user = User::find($id);
    //     $user->delete();

    //     return redirect()->route('roles.index');
    // }
}

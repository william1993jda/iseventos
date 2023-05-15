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

        if ($query) {
            $roles = Role::where('name', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('roles.index', compact('users', 'query'));
        }

        $roles = Role::paginate(10);

        return view('roles.index', compact('roles', 'query'));
    }

    public function create(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();

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

        return view('roles.form', compact('role', 'permissions'));
    }

    public function store(Role $role, Request $request)
    {
        $params = $request->all();

        if ($params) {
            $role->syncPermissions($params['permission_id']);

            return redirect()->route('roles.index');
        }
    }
}

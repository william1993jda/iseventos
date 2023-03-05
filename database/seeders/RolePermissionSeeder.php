<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'financeiro_human_resources']);
        Role::firstOrCreate(['name' => 'commercial_administrative']);
        Role::firstOrCreate(['name' => 'stock']);

        $user = User::find(1);

        if (!empty($user)) {

            $permissionRolesList = Permission::firstOrCreate(['name' => 'roles.index']);
            $permissionRolesCreate = Permission::firstOrCreate(['name' => 'roles.create']);
            $permissionRolesEdit = Permission::firstOrCreate(['name' => 'roles.edit']);
            $permissionRolesDestroy = Permission::firstOrCreate(['name' => 'roles.destroy']);

            $adminRole->syncPermissions([
                $permissionRolesList,
                $permissionRolesCreate,
                $permissionRolesEdit,
                $permissionRolesDestroy
            ]);

            $user->syncRoles(['admin']);
        }

        Permission::firstOrCreate(['name' => 'users.index']);
        Permission::firstOrCreate(['name' => 'users.create']);
        Permission::firstOrCreate(['name' => 'users.edit']);
        Permission::firstOrCreate(['name' => 'users.destroy']);

        Permission::firstOrCreate(['name' => 'employees.index']);
        Permission::firstOrCreate(['name' => 'employees.create']);
        Permission::firstOrCreate(['name' => 'employees.edit']);
        Permission::firstOrCreate(['name' => 'employees.destroy']);

        Permission::firstOrCreate(['name' => 'employees.contacts.index']);
        Permission::firstOrCreate(['name' => 'employees.contacts.create']);
        Permission::firstOrCreate(['name' => 'employees.contacts.edit']);
        Permission::firstOrCreate(['name' => 'employees.contacts.destroy']);

        Permission::firstOrCreate(['name' => 'labors.index']);
        Permission::firstOrCreate(['name' => 'labors.create']);
        Permission::firstOrCreate(['name' => 'labors.edit']);
        Permission::firstOrCreate(['name' => 'labors.destroy']);
    }
}

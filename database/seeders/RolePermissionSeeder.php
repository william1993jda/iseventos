<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email', 'rgazeredo@gmail.com')->first();

        if (empty($user)) {
            $user = User::firstOrCreate([
                'name' => 'Admin',
                'email' => 'rgazeredo@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }

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

        Permission::firstOrCreate(['name' => 'employees.addresses.index']);
        Permission::firstOrCreate(['name' => 'employees.addresses.create']);
        Permission::firstOrCreate(['name' => 'employees.addresses.edit']);
        Permission::firstOrCreate(['name' => 'employees.addresses.destroy']);

        Permission::firstOrCreate(['name' => 'employees.banks.index']);
        Permission::firstOrCreate(['name' => 'employees.banks.create']);
        Permission::firstOrCreate(['name' => 'employees.banks.edit']);
        Permission::firstOrCreate(['name' => 'employees.banks.destroy']);

        Permission::firstOrCreate(['name' => 'employees.dependents.index']);
        Permission::firstOrCreate(['name' => 'employees.dependents.create']);
        Permission::firstOrCreate(['name' => 'employees.dependents.edit']);
        Permission::firstOrCreate(['name' => 'employees.dependents.destroy']);

        Permission::firstOrCreate(['name' => 'employees.documents.index']);
        Permission::firstOrCreate(['name' => 'employees.documents.create']);
        Permission::firstOrCreate(['name' => 'employees.documents.edit']);
        Permission::firstOrCreate(['name' => 'employees.documents.destroy']);

        Permission::firstOrCreate(['name' => 'customers.index']);
        Permission::firstOrCreate(['name' => 'customers.create']);
        Permission::firstOrCreate(['name' => 'customers.edit']);
        Permission::firstOrCreate(['name' => 'customers.destroy']);

        Permission::firstOrCreate(['name' => 'customers.contacts.index']);
        Permission::firstOrCreate(['name' => 'customers.contacts.create']);
        Permission::firstOrCreate(['name' => 'customers.contacts.edit']);
        Permission::firstOrCreate(['name' => 'customers.contacts.destroy']);

        Permission::firstOrCreate(['name' => 'customers.addresses.index']);
        Permission::firstOrCreate(['name' => 'customers.addresses.create']);
        Permission::firstOrCreate(['name' => 'customers.addresses.edit']);
        Permission::firstOrCreate(['name' => 'customers.addresses.destroy']);

        Permission::firstOrCreate(['name' => 'providers.index']);
        Permission::firstOrCreate(['name' => 'providers.create']);
        Permission::firstOrCreate(['name' => 'providers.edit']);
        Permission::firstOrCreate(['name' => 'providers.destroy']);

        Permission::firstOrCreate(['name' => 'providers.contacts.index']);
        Permission::firstOrCreate(['name' => 'providers.contacts.create']);
        Permission::firstOrCreate(['name' => 'providers.contacts.edit']);
        Permission::firstOrCreate(['name' => 'providers.contacts.destroy']);

        Permission::firstOrCreate(['name' => 'providers.addresses.index']);
        Permission::firstOrCreate(['name' => 'providers.addresses.create']);
        Permission::firstOrCreate(['name' => 'providers.addresses.edit']);
        Permission::firstOrCreate(['name' => 'providers.addresses.destroy']);

        Permission::firstOrCreate(['name' => 'providers.banks.index']);
        Permission::firstOrCreate(['name' => 'providers.banks.create']);
        Permission::firstOrCreate(['name' => 'providers.banks.edit']);
        Permission::firstOrCreate(['name' => 'providers.banks.destroy']);

        Permission::firstOrCreate(['name' => 'providers.os-products.index']);
        Permission::firstOrCreate(['name' => 'providers.os-products.create']);
        Permission::firstOrCreate(['name' => 'providers.os-products.edit']);
        Permission::firstOrCreate(['name' => 'providers.os-products.destroy']);

        Permission::firstOrCreate(['name' => 'labors.index']);
        Permission::firstOrCreate(['name' => 'labors.create']);
        Permission::firstOrCreate(['name' => 'labors.edit']);
        Permission::firstOrCreate(['name' => 'labors.destroy']);

        Permission::firstOrCreate(['name' => 'places.index']);
        Permission::firstOrCreate(['name' => 'places.create']);
        Permission::firstOrCreate(['name' => 'places.edit']);
        Permission::firstOrCreate(['name' => 'places.destroy']);

        Permission::firstOrCreate(['name' => 'places.documents.index']);
        Permission::firstOrCreate(['name' => 'places.documents.create']);
        Permission::firstOrCreate(['name' => 'places.documents.edit']);
        Permission::firstOrCreate(['name' => 'places.documents.destroy']);

        Permission::firstOrCreate(['name' => 'places.rooms.index']);
        Permission::firstOrCreate(['name' => 'places.rooms.create']);
        Permission::firstOrCreate(['name' => 'places.rooms.edit']);
        Permission::firstOrCreate(['name' => 'places.rooms.destroy']);

        Permission::firstOrCreate(['name' => 'places.rooms.documents.index']);
        Permission::firstOrCreate(['name' => 'places.rooms.documents.create']);
        Permission::firstOrCreate(['name' => 'places.rooms.documents.edit']);
        Permission::firstOrCreate(['name' => 'places.rooms.documents.destroy']);

        Permission::firstOrCreate(['name' => 'statuses.list']);
        Permission::firstOrCreate(['name' => 'statuses.create']);
        Permission::firstOrCreate(['name' => 'statuses.edit']);
        Permission::firstOrCreate(['name' => 'statuses.destroy']);

        Permission::firstOrCreate(['name' => 'os-statuses.list']);
        Permission::firstOrCreate(['name' => 'os-statuses.create']);
        Permission::firstOrCreate(['name' => 'os-statuses.edit']);
        Permission::firstOrCreate(['name' => 'os-statuses.destroy']);

        Permission::firstOrCreate(['name' => 'categories.list']);
        Permission::firstOrCreate(['name' => 'categories.create']);
        Permission::firstOrCreate(['name' => 'categories.edit']);
        Permission::firstOrCreate(['name' => 'categories.destroy']);

        Permission::firstOrCreate(['name' => 'os-categories.list']);
        Permission::firstOrCreate(['name' => 'os-categories.create']);
        Permission::firstOrCreate(['name' => 'os-categories.edit']);
        Permission::firstOrCreate(['name' => 'os-categories.destroy']);

        Permission::firstOrCreate(['name' => 'products.list']);
        Permission::firstOrCreate(['name' => 'products.create']);
        Permission::firstOrCreate(['name' => 'products.edit']);
        Permission::firstOrCreate(['name' => 'products.destroy']);

        Permission::firstOrCreate(['name' => 'os-products.list']);
        Permission::firstOrCreate(['name' => 'os-products.create']);
        Permission::firstOrCreate(['name' => 'os-products.edit']);
        Permission::firstOrCreate(['name' => 'os-products.destroy']);

        Permission::firstOrCreate(['name' => 'budgets.list']);
        Permission::firstOrCreate(['name' => 'budgets.create']);
        Permission::firstOrCreate(['name' => 'budgets.edit']);
        Permission::firstOrCreate(['name' => 'budgets.destroy']);
        Permission::firstOrCreate(['name' => 'budgets.mount']);
    }
}

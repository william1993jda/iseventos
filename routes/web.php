<?php

use App\Http\Controllers\AgencyAddressController;
use App\Http\Controllers\AgencyContactController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\EmployeeDependentController;
use App\Http\Controllers\EmployeeBankController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeAddressController;
use App\Http\Controllers\EmployeeContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceDocumentController;
use App\Http\Controllers\PlaceRoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderAddressController;
use App\Http\Controllers\ProviderBankController;
use App\Http\Controllers\ProviderContactController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/list', [StoryboardController::class, 'list'])->name('storyboard.list');
    Route::get('/form', [StoryboardController::class, 'form'])->name('storyboard.form');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create/{role}', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store/{role}', [RoleController::class, 'store'])->name('roles.store');

    Route::resource('users', UserController::class)->names('users');

    Route::resource('employees', EmployeeController::class)->names('employees');
    Route::resource('employees.contacts', EmployeeContactController::class)->names('employees.contacts');
    Route::resource('employees.addresses', EmployeeAddressController::class)->names('employees.addresses');
    Route::resource('employees.banks', EmployeeBankController::class)->names('employees.banks');
    Route::resource('employees.dependents', EmployeeDependentController::class)->names('employees.dependents');

    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('customers.contacts', CustomerContactController::class)->names('customers.contacts');
    Route::resource('customers.addresses', CustomerAddressController::class)->names('customers.addresses');

    Route::resource('agencies', AgencyController::class)->names('agencies');
    Route::resource('agencies.contacts', AgencyContactController::class)->names('agencies.contacts');
    Route::resource('agencies.addresses', AgencyAddressController::class)->names('agencies.addresses');

    Route::resource('providers', ProviderController::class)->names('providers');
    Route::resource('providers.contacts', ProviderContactController::class)->names('providers.contacts');
    Route::resource('providers.addresses', ProviderAddressController::class)->names('providers.addresses');
    Route::resource('providers.banks', ProviderBankController::class)->names('providers.banks');

    Route::resource('places', PlaceController::class)->names('places');
    Route::resource('places.rooms', PlaceRoomController::class)->names('places.rooms');
    Route::resource('places.documents', PlaceDocumentController::class)->names('places.documents');

    Route::resource('labors', LaborController::class)->names('labors');

    Route::post('budgets/customer-contacts', [BudgetController::class, 'getCustomerContacts'])->name('budgets.getCustomerContacts');
    Route::get('budgets/mount/{budget}', [BudgetController::class, 'mount'])->name('budgets.mount');
    Route::get('budgets/print/{budget}', [BudgetController::class, 'print'])->name('budgets.print');
    Route::delete('budgets/room/product/{budgetRoomProduct}', [BudgetController::class, 'roomProductDestroy'])->name('budgets.room.product.destroy');
    Route::delete('budgets/room/labor/{budgetRoomLabor}', [BudgetController::class, 'roomLaborDestroy'])->name('budgets.room.labor.destroy');
    Route::resource('budgets', BudgetController::class)->names('budgets');

    Route::any('/imports/products', [ImportController::class, 'products'])->name('imports.products');
    Route::any('/imports/os-products', [ImportController::class, 'osProducts'])->name('imports.os-products');
});

require __DIR__ . '/auth.php';

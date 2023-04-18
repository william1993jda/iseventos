<?php

use App\Http\Controllers\AgencyAddressController;
use App\Http\Controllers\AgencyContactController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetExpenseController;
use App\Http\Controllers\BudgetDocumentController;
use App\Http\Controllers\OrderServiceController;
use App\Http\Controllers\OrderServiceDocumentController;
use App\Http\Controllers\EmployeeDependentController;
use App\Http\Controllers\EmployeeBankController;
use App\Http\Controllers\FreelancerDependentController;
use App\Http\Controllers\FreelancerBankController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDocumentController;
use App\Http\Controllers\EmployeeAddressController;
use App\Http\Controllers\EmployeeContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\FreelancerAddressController;
use App\Http\Controllers\FreelancerContactController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FreelancerDocumentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupProductController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\BriefingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\OsStatusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OsCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OsProductController;
use App\Http\Controllers\PlaceDocumentController;
use App\Http\Controllers\PlaceRoomController;
use App\Http\Controllers\PlaceRoomDocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderAddressController;
use App\Http\Controllers\ProviderBankController;
use App\Http\Controllers\ProviderContactController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderOsProductController;
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
    Route::resource('employees.documents', EmployeeDocumentController::class)->names('employees.documents');

    Route::resource('freelancers', FreelancerController::class)->names('freelancers');
    Route::resource('freelancers.contacts', FreelancerContactController::class)->names('freelancers.contacts');
    Route::resource('freelancers.addresses', FreelancerAddressController::class)->names('freelancers.addresses');
    Route::resource('freelancers.banks', FreelancerBankController::class)->names('freelancers.banks');
    Route::resource('freelancers.dependents', FreelancerDependentController::class)->names('freelancers.dependents');
    Route::resource('freelancers.documents', FreelancerDocumentController::class)->names('freelancers.documents');

    Route::resource('customers', CustomerController::class)->names('customers');
    Route::resource('customers.contacts', CustomerContactController::class)->names('customers.contacts');
    Route::resource('customers.addresses', CustomerAddressController::class)->names('customers.addresses');
    Route::resource('customers.documents', CustomerDocumentController::class)->names('customers.documents');

    Route::resource('agencies', AgencyController::class)->names('agencies');
    Route::resource('agencies.contacts', AgencyContactController::class)->names('agencies.contacts');
    Route::resource('agencies.addresses', AgencyAddressController::class)->names('agencies.addresses');

    Route::resource('providers', ProviderController::class)->names('providers');
    Route::resource('providers.contacts', ProviderContactController::class)->names('providers.contacts');
    Route::resource('providers.addresses', ProviderAddressController::class)->names('providers.addresses');
    Route::resource('providers.banks', ProviderBankController::class)->names('providers.banks');
    Route::resource('providers.products', ProviderOsProductController::class)->names('providers.os-products');

    Route::resource('places', PlaceController::class)->names('places');
    Route::resource('places.documents', PlaceDocumentController::class)->names('places.documents');
    Route::resource('places.rooms', PlaceRoomController::class)->names('places.rooms');
    Route::resource('places.rooms.documents', PlaceRoomDocumentController::class)->names('places.rooms.documents');

    Route::resource('labors', LaborController::class)->names('labors');

    Route::get('briefings/create/{type}', [BriefingController::class, 'create'])->name('briefings.create.type');
    Route::post('briefings/store/online', [BriefingController::class, 'storeOnline'])->name('briefings.store.online');
    Route::put('briefings/update/online', [BriefingController::class, 'updateOnline'])->name('briefings.update.online');
    Route::post('briefings/store/person', [BriefingController::class, 'storePerson'])->name('briefings.store.person');
    Route::put('briefings/update/person', [BriefingController::class, 'updatePerson'])->name('briefings.update.person');
    Route::post('briefings/store/hybrid', [BriefingController::class, 'storeHybrid'])->name('briefings.store.hybrid');
    Route::put('briefings/update/hybrid', [BriefingController::class, 'updateHybrid'])->name('briefings.update.hybrid');
    Route::resource('briefings', BriefingController::class)->names('briefings');

    Route::resource('statuses', StatusController::class)->names('statuses');

    Route::resource('os-statuses', OsStatusController::class)->names('os-statuses');

    Route::resource('categories', CategoryController::class)->names('categories');

    Route::resource('os-categories', OsCategoryController::class)->names('os-categories');

    Route::resource('products', ProductController::class)->names('products');

    Route::resource('os-products', OsProductController::class)->names('os-products');

    Route::resource('groups', GroupController::class)->names('groups');

    Route::resource('groups.products', GroupProductController::class)->names('groups.products');


    Route::post('budgets/customer-contacts', [BudgetController::class, 'getCustomerContacts'])->name('budgets.getCustomerContacts');
    Route::get('budgets/mount/{budget}', [BudgetController::class, 'mount'])->name('budgets.mount');
    Route::get('budgets/print/{budget}', [BudgetController::class, 'print'])->name('budgets.print');
    Route::delete('budgets/room/product/{budgetRoomProduct}', [BudgetController::class, 'roomProductDestroy'])->name('budgets.room.product.destroy');
    Route::delete('budgets/room/labor/{budgetRoomLabor}', [BudgetController::class, 'roomLaborDestroy'])->name('budgets.room.labor.destroy');
    Route::resource('budgets', BudgetController::class)->names('budgets');
    Route::resource('budgets.expenses', BudgetExpenseController::class)->names('budgets.expenses');
    Route::resource('budgets.documents', BudgetDocumentController::class)->names('budgets.documents');

    Route::get('orderServices/mount/{orderService}', [OrderServiceController::class, 'mount'])->name('orderServices.mount');
    Route::get('orderServices/print/{orderService}', [OrderServiceController::class, 'print'])->name('orderServices.print');
    Route::get('orderServices/print/provider/{orderService}/{provider}', [OrderServiceController::class, 'printProvider'])->name('orderServices.print.provider');
    Route::delete('orderServices/room/product/{orderServiceRoomProduct}', [OrderServiceController::class, 'roomProductDestroy'])->name('orderServices.room.product.destroy');
    Route::delete('orderServices/room/provider/{orderServiceRoomProvider}', [OrderServiceController::class, 'roomProviderDestroy'])->name('orderServices.room.provider.destroy');
    Route::delete('orderServices/room/provider/{orderServiceRoomGroup}', [OrderServiceController::class, 'roomGroupDestroy'])->name('orderServices.room.group.destroy');
    Route::resource('orderServices', OrderServiceController::class)->names('orderServices');
    Route::resource('orderServices.documents', OrderServiceDocumentController::class)->names('orderServices.documents');


    Route::any('/imports/products', [ImportController::class, 'products'])->name('imports.products');
    Route::any('/imports/os-products', [ImportController::class, 'osProducts'])->name('imports.os-products');
});

require __DIR__ . '/auth.php';

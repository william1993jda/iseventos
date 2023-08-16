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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderServiceCheckController;
use App\Http\Controllers\OrderServiceExpenseController;
use App\Http\Controllers\OsCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OsProductController;
use App\Http\Controllers\OsProductStockController;
use App\Http\Controllers\PlaceDocumentController;
use App\Http\Controllers\PlaceRoomController;
use App\Http\Controllers\PlaceRoomDocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderAddressController;
use App\Http\Controllers\ProviderBankController;
use App\Http\Controllers\ProviderContactController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderOsProductController;
use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryboardController;
use App\Http\Controllers\SubleasedController;
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

Route::prefix('front')->group(function () {
    Route::get('briefings', [BriefingController::class, 'indexFront'])->name('front.briefings.index');
    Route::get('briefings/create/{type}', [BriefingController::class, 'createFront'])->name('front.briefings.create.type');
    Route::post('briefings/store/online', [BriefingController::class, 'storeOnlineFront'])->name('front.briefings.store.online');
    Route::post('briefings/store/person', [BriefingController::class, 'storePersonFront'])->name('front.briefings.store.person');
    Route::post('briefings/store/hybrid', [BriefingController::class, 'storeHybridFront'])->name('front.briefings.store.hybrid');
});

Route::middleware('auth')->group(function () {
    Route::get('/list', [StoryboardController::class, 'list'])->name('storyboard.list');
    Route::get('/form', [StoryboardController::class, 'form'])->name('storyboard.form');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create/{role}', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store/{role}', [RoleController::class, 'store'])->name('roles.store');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
    Route::put('briefings/update/online/{id}', [BriefingController::class, 'updateOnline'])->name('briefings.update.online');
    Route::post('briefings/store/person', [BriefingController::class, 'storePerson'])->name('briefings.store.person');
    Route::put('briefings/update/person/{id}', [BriefingController::class, 'updatePerson'])->name('briefings.update.person');
    Route::post('briefings/store/hybrid', [BriefingController::class, 'storeHybrid'])->name('briefings.store.hybrid');
    Route::put('briefings/update/hybrid/{id}', [BriefingController::class, 'updateHybrid'])->name('briefings.update.hybrid');
    Route::resource('briefings', BriefingController::class)->names('briefings');

    Route::resource('statuses', StatusController::class)->names('statuses');

    Route::resource('os-statuses', OsStatusController::class)->names('os-statuses');

    Route::resource('categories', CategoryController::class)->names('categories');

    Route::resource('os-categories', OsCategoryController::class)->names('os-categories');

    Route::resource('products', ProductController::class)->names('products');

    Route::resource('os-products', OsProductController::class)->names('os-products');
    Route::resource('os-products.stocks', OsProductStockController::class)->names('os-products.stocks');

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

    Route::get('order-services/mount/{orderService}', [OrderServiceController::class, 'mount'])->name('orderServices.mount');
    Route::get('order-services/print/{orderService}', [OrderServiceController::class, 'print'])->name('orderServices.print');
    Route::get('order-services/print/provider/{orderService}/{provider}', [OrderServiceController::class, 'printProvider'])->name('orderServices.print.provider');
    Route::get('order-services/print/freelancer/{orderService}', [OrderServiceController::class, 'printFreelancer'])->name('orderServices.print.freelancer');
    Route::delete('order-services/room/product/{orderServiceRoomProduct}', [OrderServiceController::class, 'roomProductDestroy'])->name('orderServices.room.product.destroy');
    Route::delete('order-services/room/provider/{orderServiceRoomProvider}', [OrderServiceController::class, 'roomProviderDestroy'])->name('orderServices.room.provider.destroy');
    Route::delete('order-services/room/provider/{orderServiceRoomGroup}', [OrderServiceController::class, 'roomGroupDestroy'])->name('orderServices.room.group.destroy');
    Route::delete('order-services/room/freelancer/{orderServiceRoomFreelancer}', [OrderServiceController::class, 'roomFreelancerDestroy'])->name('orderServices.room.freelancer.destroy');
    Route::resource('order-services', OrderServiceController::class)->names('orderServices');
    Route::get('order-services/create/{budget}', [OrderServiceController::class, 'create'])->name('orderServices.create.budget');
    Route::resource('order-services.documents', OrderServiceDocumentController::class)->names('orderServices.documents');
    Route::resource('order-services.checks', OrderServiceCheckController::class)->names('orderServices.checks');
    Route::resource('order-services.expenses', OrderServiceExpenseController::class)->names('orderServices.expenses');

    Route::any('/imports/products', [ImportController::class, 'products'])->name('imports.products');
    Route::any('/imports/os-products', [ImportController::class, 'osProducts'])->name('imports.os-products');

    Route::any('recoveries', [RecoveryController::class, 'index'])->name('recoveries.index');
    Route::post('recoveries/recovery/{id}', [RecoveryController::class, 'recovery'])->name('recoveries.recovery');

    Route::get('subleases', [SubleasedController::class, 'index'])->name('subleases.index');
    Route::get('subleases/items/{sublease}', [SubleasedController::class, 'items'])->name('subleases.items');
    Route::get('subleases/items/check/{subleaseItem}', [SubleasedController::class, 'checkItem'])->name('subleases.items.check');
    Route::get('subleases/items/uncheck/{subleaseItem}', [SubleasedController::class, 'uncheckItem'])->name('subleases.items.uncheck');

    Route::get('reports/events', [ReportController::class, 'events'])->name('reports.events');
    Route::get('reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('reports/providers', [ReportController::class, 'providers'])->name('reports.providers');
    Route::get('reports/providers/detail/{provider}', [ReportController::class, 'providerDetail'])->name('reports.providers.detail');
    Route::get('reports/freelancers', [ReportController::class, 'freelancers'])->name('reports.freelancers');
    Route::get('reports/freelancers/detail/{freelancer}', [ReportController::class, 'freelancerDetail'])->name('reports.freelancers.detail');
});

require __DIR__ . '/auth.php';

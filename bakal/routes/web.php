<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CustomerController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactPersonController;

use App\Http\Controllers\ProducerController;
use App\Http\Controllers\ProductOriginalController;
use App\Http\Controllers\ProductMixedController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageItemController;
use App\Http\Controllers\MixingProductController;
use App\Http\Controllers\OrderWorkController;

use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LoginEmployeeController;
use App\Http\Controllers\LoginCustomerController;
use App\Http\Controllers\GoogleCalendarController;

use App\Http\Controllers\StatsController;

use Spatie\GoogleCalendar\Event;
use Phpml\Association\Apriori;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    if(auth('admin')->user()) {
        
        return view('admins/success');
    } else if(auth('employee')->user()) {
        
        return view('employees/welcome');
    } else if(auth('customer')->user()) {
        
        return view('customers/welcome');
    }else {
        return view('customers.login');
    }
    
})->name('start');




Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admins/logout', [LoginAdminController::class, 'logout'])->name('admins.logout');

    

    Route::get('/customers/index', [CustomerController::class, 'index'])->name('customers.index');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/customers/{id}/change_passwordAdmin', [CustomerController::class, 'changePasswordAdmin'])->name('customers.change_passwordAdmin');
    Route::post('/customers/{id}/update_passwordAdmin', [CustomerController::class, 'updatePasswordAdmin'])->name('customers.update_passwordAdmin');


    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/index', [EmployeeController::class, 'index'])->name('employees.index');

    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('/employees/change_password/{emplId}', [EmployeeController::class, 'changePasswordAdmin'])->name('employees.change_password.admin');
Route::post('/employees/{id}/update_passwordAdmin', [EmployeeController::class, 'updatePasswordAdmin'])->name('employees.update_passwordAdmin');

Route::get('/departments/index', [DepartmentController::class, 'index'])->name('departments.index');
Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');


Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::post('/admins/{id}/update', [AdminController::class, 'update'])->name('admins.update');

Route::get('/admins/change_password', [AdminController::class, 'change_password'])->name('admins.change_password');
Route::post('/admins/{id}/update_password', [AdminController::class, 'update_password'])->name('admins.update_password');

Route::get('/admins/success', [LoginAdminController::class, 'success'])->name('admins.success');

Route::get('/contact/{subid}/create', [ContactPersonController::class, 'createAsAdmin'])->name('contact.admin.create');
Route::post('/contact/{subid}/store', [ContactPersonController::class, 'storeAsAdmin'])->name('contact.admin.store');


Route::get('/contact/index', [ContactPersonController::class, 'index'])->name('contact.index');
 


Route::get('/producers/create', [ProducerController::class, 'create'])->name('producers.create');

Route::post('/producers/store', [ProducerController::class, 'store'])->name('producers.store');

Route::get('/productOriginal/create', [ProductOriginalController::class, 'create'])->name('productOriginal.create');
Route::post('/productOriginal/store', [ProductOriginalController::class, 'store'])->name('productOriginal.store');

Route::get('/productOriginal/edit/{id}', [ProductOriginalController::class, 'edit'])->name('productOriginal.edit');
Route::put('/productOriginal/{id}/update', [ProductOriginalController::class, 'update'])->name('productOriginal.update');
Route::delete('/productOriginal/{id}', [ProductOriginalController::class, 'destroy'])->name('productOriginal.destroy');


Route::get('/containers/create', [ContainerController::class, 'create'])->name('containers.create');
Route::post('/containers/store', [ContainerController::class, 'store'])->name('containers.store');

Route::get('/containers/{id}/edit', [ContainerController::class, 'edit'])->name('containers.edit');
Route::put('/containers/{id}/update', [ContainerController::class, 'update'])->name('containers.update');
Route::delete('/containers/{id}', [ContainerController::class, 'destroy'])->name('containers.destroy');

Route::get('/productMixed/create', [ProductMixedController::class, 'create'])->name('productMixed.create');
Route::post('/productMixed/store', [ProductMixedController::class, 'store'])->name('productMixed.store');
Route::get('/productMixed/{id}/edit', [ProductMixedController::class, 'edit'])->name('productMixed.edit');
Route::put('/productMixed/{id}/update', [ProductMixedController::class, 'update'])->name('productMixed.update');
Route::delete('/productMixed/{id}', [ProductMixedController::class, 'destroy'])->name('productMixed.destroy');

Route::post('/orders/{subid}/store', [OrderController::class, 'storeAdmin'])->name('orders.admin.store');


Route::get('/mixingProduct/create', [MixingProductController::class, 'create'])->name('mixingProduct.create');
Route::post('/mixingProduct/store/{mixedId}', [MixingProductController::class, 'store'])->name('mixingProduct.store');
Route::delete('/mixingProduct/{mixingId}', [MixingProductController::class, 'destroy'])->name('mixingProduct.destroy');

Route::get('/orderWork/create/admin/{emplId}', [OrderWorkController::class, 'createAsAdmin'])->name('orderWork.admin.create');
Route::post('/orderWork/store/admin/{emplId}', [OrderWorkController::class, 'storeAsAdmin'])->name('orderWork.admin.store');
});


Route::group(['middleware' => 'auth:employee'], function () {
    Route::get('/employees/logout', [LoginEmployeeController::class, 'logout'])->name('employees.logout');
Route::get('/employees/welcome', [LoginEmployeeController::class, 'welcome'])->name('employees.welcome');
Route::get('/employees/change_password', [EmployeeController::class, 'changePassword'])->name('employees.change_password');
Route::post('/employees/{id}/update_password', [EmployeeController::class, 'updatePassword'])->name('employees.update_password');

Route::get('/calendar/index', [GoogleCalendarController::class, 'index'])->name('google.index');
});

Route::group(['middleware' => 'auth:customer'], function () {
    Route::get('/orders/{id}/index', [OrderController::class, 'myindex'])->name('orders.myindex');

    Route::get('/customers/logout', [LoginCustomerController::class, 'logout'])->name('customers.logout');

    Route::get('/customers/change_password', [CustomerController::class, 'change_password'])->name('customers.change_password');
Route::post('/customers/{id}/update_password', [CustomerController::class, 'update_password'])->name('customers.update_password');
Route::get('/customers/welcome', [LoginCustomerController::class, 'welcome'])->name('customers.welcome');

Route::get('/contact/create', [ContactPersonController::class, 'create'])->name('contact.create');
Route::post('/contact/store', [ContactPersonController::class, 'store'])->name('contact.store');
Route::get('/contact/{subId}/index', [ContactPersonController::class, 'indexSub'])->name('contact.index.sub');

Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

});

Route::group(['middleware' => 'auth:customer,admin'], function () {
    

    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update');

Route::delete('/contact/{id}', [ContactPersonController::class, 'destroy'])->name('contact.destroy');
Route::get('/contact/{id}', [ContactPersonController::class, 'edit'])->name('contact.edit');
Route::put('/contact/{id}/update', [ContactPersonController::class, 'update'])->name('contact.update');

Route::put('/containers/{id}/addStore', [ContainerController::class, 'addOnStore'])->name('containers.addStore');

Route::get('/items/create/{orderid}', [ItemController::class, 'create'])->name('items.create');
Route::post('/items/store/{orderid}/{productcode}', [ItemController::class, 'store'])->name('items.store');
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

Route::get('/packageItem/create/{itemid}', [PackageItemController::class, 'create'])->name('packageItem.create');
Route::post('/packageItem/store/{itemid}/{containerid}', [PackageItemController::class, 'store'])->name('packageItem.store');
Route::get('/packageItem/show/{itemid}', [PackageItemController::class, 'show'])->name('packageItem.show');
Route::delete('/packageItem/{id}', [PackageItemController::class, 'destroy'])->name('packageItem.destroy');
Route::put('/packageItem/changeCount/{id}', [PackageItemController::class, 'changeCount'])->name('packageItem.changeCount');

Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::put('/orders/changeTerm/{orderId}', [OrderController::class, 'changeTerm'])->name('orders.changeTerm');

Route::get('/orders/edit/{idOrder}', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/update/{orderId}', [OrderController::class, 'update'])->name('orders.update');
});

Route::group(['middleware' => 'auth:employee,admin'], function () {

    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');

    Route::put('/productOriginal/{id}/addStore', [ProductOriginalController::class, 'addOnStore'])->name('productOriginal.addStore');

    Route::get('/mixingProduct/index', [MixingProductController::class, 'index'])->name('mixingProduct.index');
Route::get('/mixingProduct/show/{mixedId}', [MixingProductController::class, 'show'])->name('mixingProduct.show');

Route::put('/orders/changeState/{idOrder}', [OrderController::class, 'changeState'])->name('orders.changeState');
Route::post('/orders/uploadFile/{orderId}', [OrderController::class, 'uploadFile'])->name('orders.uploadFile');

Route::get('/orderWork/create/{orderId}', [OrderWorkController::class, 'create'])->name('orderWork.create');
Route::post('/orderWork/store/{orderId}', [OrderWorkController::class, 'store'])->name('orderWork.store');
Route::delete('/orderWork/destroy/{id}', [OrderWorkController::class, 'destroy'])->name('orderWork.destroy');
Route::get('/orderWork/index', [OrderWorkController::class, 'index'])->name('orderWork.index');
    
});
Route::group(['middleware' => 'auth:employee,admin,customer'], function () {
    Route::get('/containers/index', [ContainerController::class, 'index'])->name('containers.index');
    Route::get('/productOriginal/index', [ProductOriginalController::class, 'index'])->name('product.index');

    Route::put('/productMixed/{id}/asddStore', [ProductMixedController::class, 'addOnStore'])->name('productMixed.addStore');

 
    Route::get('/orders/index/filter', [OrderController::class, 'indexFilter'])->name('orders.index.filter');

    Route::get('/orders/index', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('orders.show');

    Route::get('orders/downloadInvoice/{file_name}', function($file_name = null) {
        $path = storage_path().'/app/public/invoices/'.$file_name;
    
        if(file_exists($path)) {
            
            return Response::download($path);
        }
    })->name('orders.downloadInvoice');
});

Route::group(['middleware' => 'guest'], function () {
    
    

    
});

Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');

Route::get('/customers/login', [LoginCustomerController::class, 'index'])->name('customers.login');
Route::post('/customers/login', [LoginCustomerController::class, 'login'])->name('customers.login.post');

Route::get('/employees/login', [LoginEmployeeController::class, 'index'])->name('employees.login');
Route::post('/employees/login', [LoginEmployeeController::class, 'login'])->name('employees.login.post');



Route::get('/admins/login', [LoginAdminController::class, 'index'])->name('admins.login');
Route::post('/admins/login', [LoginAdminController::class, 'login'])->name('admins.login.post');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

Route::get('/test', [OrderController::class, 'test'])->name('test');

Route::get('/admins/index', [AdminController::class, 'create'])->name('admins.index');
Route::post('/admins/store', [AdminController::class, 'store'])->name('admins.store');


////////////////////////////////////////

//Admin Home page after login
/*
Route::group(['middleware'=>'admin'], function() {
    Route::get('/admin/home', 'Admin\HomeController@index');
});*/
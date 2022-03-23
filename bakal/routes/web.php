<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\RegisterSubscriberController;

use App\Http\Controllers\LoginSubscriberController;

use App\Http\Controllers\RegisterSubController;
use App\Http\Controllers\LoginSubController;
use App\Http\Controllers\RegisterEmployeeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;

use App\Http\Controllers\RegisterAdminController;
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
    return view('subscribers.login');
});




Route::get('/subsribers/create', [RegisterSubController::class, 'create'])->name('subscribers.create');
Route::get('/subsribers/index', [RegisterSubController::class, 'index'])->name('subscribers.index');
Route::post('/subscribers/store', [RegisterSubController::class, 'store'])->name('subscribers.store');
Route::get('/subscribers/{id}/edit', [RegisterSubController::class, 'edit'])->name('subscribers.edit');
Route::put('/subscribers/{id}/update', [RegisterSubController::class, 'update'])->name('subscribers.update');
Route::delete('/subscribers/{id}', [RegisterSubController::class, 'destroy'])->name('subscribers.destroy');

Route::get('/subscribers/change_password', [RegisterSubController::class, 'change_password'])->name('subscribers.change_password');
Route::post('/subscribers/{id}/update_password', [RegisterSubController::class, 'update_password'])->name('subscribers.update_password');

Route::get('/subscribers/login', [LoginCustomerController::class, 'index'])->name('subscribers.login');
Route::post('/subscribers/login', [LoginCustomerController::class, 'login'])->name('subscribers.login.post');
Route::get('/subscribers/logout', [LoginCustomerController::class, 'logout'])->name('subscribers.logout');
Route::get('/subscribers/welcome', [LoginCustomerController::class, 'welcome'])->name('subscribers.welcome');

Route::get('/employees/create', [RegisterEmployeeController::class, 'index'])->name('employees.create');
Route::post('/employees/store', [RegisterEmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/index', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('/employees/login', [LoginEmployeeController::class, 'index'])->name('employees.login');
Route::post('/employees/login', [LoginEmployeeController::class, 'login'])->name('employees.login.post');
Route::get('/employees/logout', [LoginEmployeeController::class, 'logout'])->name('employees.logout');
Route::get('/employees/welcome', [LoginEmployeeController::class, 'welcome'])->name('employees.welcome');
Route::get('/employees/change_password', [RegisterEmployeeController::class, 'change_password'])->name('employees.change_password');
Route::post('/employees/{id}/update_password', [RegisterEmployeeController::class, 'update_password'])->name('employees.update_password');

Route::get('/departments/index', [DepartmentController::class, 'index'])->name('departments.index');
Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');

Route::get('/admins/index', [RegisterAdminController::class, 'index'])->name('admins.index');
Route::post('/admins/store', [RegisterAdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{id}/edit', [RegisterAdminController::class, 'edit'])->name('admins.edit');
Route::post('/admins/{id}/update', [RegisterAdminController::class, 'update'])->name('admins.update');

Route::get('/admins/change_password', [RegisterAdminController::class, 'change_password'])->name('admins.change_password');
Route::post('/admins/{id}/update_password', [RegisterAdminController::class, 'update_password'])->name('admins.update_password');



Route::get('/admins/login', [LoginAdminController::class, 'index'])->name('admins.login');
Route::post('/admins/login', [LoginAdminController::class, 'login'])->name('admins.login.post');
Route::get('/admins/logout', [LoginAdminController::class, 'logout'])->name('admins.logout');

Route::get('/admins/success', [LoginAdminController::class, 'success'])->name('admins.success');


Route::get('/contact/create', [ContactPersonController::class, 'create'])->name('contact.create');
Route::post('/contact/store', [ContactPersonController::class, 'store'])->name('contact.store');
Route::get('/contact/index', [ContactPersonController::class, 'index'])->name('contact.index');
Route::get('/contact/{subId}/index', [ContactPersonController::class, 'indexSub'])->name('contact.index.sub');
Route::get('/contact/{id}', [ContactPersonController::class, 'edit'])->name('contact.edit');
Route::put('/contact/{id}/update', [ContactPersonController::class, 'update'])->name('contact.update');
Route::delete('/contact/{id}', [ContactPersonController::class, 'destroy'])->name('contact.destroy');

Route::get('/producers/index', [ProducerController::class, 'index'])->name('producers.index');
Route::post('/producers/store', [ProducerController::class, 'store'])->name('producers.store');

Route::get('/productOriginal/create', [ProductOriginalController::class, 'create'])->name('productOriginal.create');
Route::post('/productOriginal/store', [ProductOriginalController::class, 'store'])->name('productOriginal.store');
Route::get('/productOriginal/index', [ProductOriginalController::class, 'index'])->name('productOriginal.index');
Route::get('/productOriginal/{id}', [ProductOriginalController::class, 'edit'])->name('productOriginal.edit');
Route::put('/productOriginal/{id}/update', [ProductOriginalController::class, 'update'])->name('productOriginal.update');
Route::delete('/productOriginal/{id}', [ProductOriginalController::class, 'destroy'])->name('productOriginal.destroy');
Route::put('/productOriginal/{id}/addStore', [ProductOriginalController::class, 'addOnStore'])->name('productOriginal.addStore');



Route::get('/containers/create', [ContainerController::class, 'create'])->name('containers.create');
Route::post('/containers/store', [ContainerController::class, 'store'])->name('containers.store');
Route::get('/containers/index', [ContainerController::class, 'index'])->name('containers.index');
Route::get('/containers/{id}', [ContainerController::class, 'edit'])->name('containers.edit');
Route::put('/containers/{id}/update', [ContainerController::class, 'update'])->name('containers.update');
Route::delete('/containers/{id}', [ContainerController::class, 'destroy'])->name('containers.destroy');
Route::put('/containers/{id}/addStore', [ContainerController::class, 'addOnStore'])->name('containers.addStore');

Route::get('/items/create/{orderid}', [ItemController::class, 'create'])->name('items.create');
Route::post('/items/store/{orderid}/{productcode}', [ItemController::class, 'store'])->name('items.store');
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

Route::get('/productMixed/create', [ProductMixedController::class, 'create'])->name('productMixed.create');
Route::post('/productMixed/store', [ProductMixedController::class, 'store'])->name('productMixed.store');
Route::get('/productMixed/{id}/edit', [ProductMixedController::class, 'edit'])->name('productMixed.edit');
Route::put('/productMixed/{id}/update', [ProductMixedController::class, 'update'])->name('productMixed.update');
Route::put('/productMixed/{id}/addStore', [ProductMixedController::class, 'addOnStore'])->name('productMixed.addStore');
Route::delete('/productMixed/{id}', [ProductMixedController::class, 'destroy'])->name('productMixed.destroy');

Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/{subid}/store', [OrderController::class, 'storeAdmin'])->name('orders.admin.store');

Route::get('/orders/index', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}/index', [OrderController::class, 'myindex'])->name('orders.myindex');
Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('orders.show');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::put('/orders/changeState/{idOrder}', [OrderController::class, 'changeState'])->name('orders.changeState');
Route::get('/orders/edit/{idOrder}', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/update/{orderId}', [OrderController::class, 'update'])->name('orders.update');
Route::put('/orders/changeTerm/{orderId}', [OrderController::class, 'changeTerm'])->name('orders.changeTerm');


Route::get('/packageItem/create/{itemid}', [PackageItemController::class, 'create'])->name('packageItem.create');
Route::post('/packageItem/store/{itemid}/{containerid}', [PackageItemController::class, 'store'])->name('packageItem.store');
Route::get('/packageItem/show/{itemid}', [PackageItemController::class, 'show'])->name('packageItem.show');
Route::delete('/packageItem/{id}', [PackageItemController::class, 'destroy'])->name('packageItem.destroy');
Route::put('/packageItem/changeCount/{id}', [PackageItemController::class, 'changeCount'])->name('packageItem.changeCount');

Route::get('/mixingProduct/create', [MixingProductController::class, 'create'])->name('mixingProduct.create');
Route::post('/mixingProduct/store/{mixedId}', [MixingProductController::class, 'store'])->name('mixingProduct.store');
Route::get('/mixingProduct/index', [MixingProductController::class, 'index'])->name('mixingProduct.index');
Route::get('/mixingProduct/show/{mixedId}', [MixingProductController::class, 'show'])->name('mixingProduct.show');
Route::delete('/mixingProduct/{mixingId}', [MixingProductController::class, 'destroy'])->name('mixingProduct.destroy');

Route::get('/orderWork/create/{orderId}', [OrderWorkController::class, 'create'])->name('orderWork.create');
Route::post('/orderWork/store/{orderId}', [OrderWorkController::class, 'store'])->name('orderWork.store');
Route::get('/orderWork/index', [OrderWorkController::class, 'index'])->name('orderWork.index');
Route::delete('/orderWork/{id}', [OrderWorkController::class, 'destroy'])->name('orderWork.destroy');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



////////////////////////////////////////

//Admin Home page after login
/*
Route::group(['middleware'=>'admin'], function() {
    Route::get('/admin/home', 'Admin\HomeController@index');
});*/
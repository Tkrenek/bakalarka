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
        
        return redirect()->route('customers.welcome');
    }else {
        return view('customers.login');
    }
    
})->name('start');




Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('/admins/index', [AdminController::class, 'create'])->name('admins.index');
    Route::post('/admins/store', [AdminController::class, 'store'])->name('admins.store');
    // odhlaseni admina
    Route::get('/admins/logout', [LoginAdminController::class, 'logout'])->name('admins.logout');

    // routy pro praci se zakazniky
    
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{id}/change_passwordAdmin', [CustomerController::class, 'changePasswordAdmin'])->name('customers.change_passwordAdmin');
    Route::post('/customers/{id}/update_passwordAdmin', [CustomerController::class, 'updatePasswordAdmin'])->name('customers.update_passwordAdmin');

    // routy pro praci se zamestnanci
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/index', [EmployeeController::class, 'index'])->name('employees.index');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/employees/change_password/{emplId}', [EmployeeController::class, 'changePasswordAdmin'])->name('employees.change_password.admin');
    Route::post('/employees/{id}/update_passwordAdmin', [EmployeeController::class, 'updatePasswordAdmin'])->name('employees.update_passwordAdmin');

    // routy pro praci s oddelenimi
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::get('/departments/index', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::delete('/departments/{id}/destroy', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    // routy pro praci s adminy
    Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::post('/admins/{id}/update', [AdminController::class, 'update'])->name('admins.update');
    Route::get('/admins/change_password', [AdminController::class, 'change_password'])->name('admins.change_password');
    Route::post('/admins/{id}/update_password', [AdminController::class, 'update_password'])->name('admins.update_password');
    Route::get('/admins/success', [LoginAdminController::class, 'success'])->name('admins.success');

    // routy pro praci s kontaktnimi osobam
    Route::get('/contact/{subid}/create', [ContactPersonController::class, 'createAsAdmin'])->name('contact.admin.create');
    Route::post('/contact/{subid}/store', [ContactPersonController::class, 'storeAsAdmin'])->name('contact.admin.store');
    

    // routy pro praci s dodavateli
    Route::get('/producers/index', [ProducerController::class, 'index'])->name('producers.index');
    Route::get('/producers/create', [ProducerController::class, 'create'])->name('producers.create');
    Route::get('/producers/edit/{id}', [ProducerController::class, 'edit'])->name('producers.edit');
    Route::put('/producers/{id}/update', [ProducerController::class, 'update'])->name('producers.update');
    Route::delete('/producers/{id}', [ProducerController::class, 'destroy'])->name('producers.destroy');
    Route::post('/producers/store', [ProducerController::class, 'store'])->name('producers.store');

    // routy pro praci s produkty originalnimi
    Route::get('/productOriginal/create', [ProductOriginalController::class, 'create'])->name('productOriginal.create');
    Route::post('/productOriginal/store', [ProductOriginalController::class, 'store'])->name('productOriginal.store');
    Route::get('/productOriginal/edit/{id}', [ProductOriginalController::class, 'edit'])->name('productOriginal.edit');
    Route::put('/productOriginal/{id}/update', [ProductOriginalController::class, 'update'])->name('productOriginal.update');
    Route::delete('/productOriginal/{id}', [ProductOriginalController::class, 'destroy'])->name('productOriginal.destroy');

    // routy pro praci s nadobami
    Route::get('/containers/create', [ContainerController::class, 'create'])->name('containers.create');
    Route::post('/containers/store', [ContainerController::class, 'store'])->name('containers.store');
    Route::get('/containers/{id}/edit', [ContainerController::class, 'edit'])->name('containers.edit');
    Route::put('/containers/{id}/update', [ContainerController::class, 'update'])->name('containers.update');
    Route::delete('/containers/{id}', [ContainerController::class, 'destroy'])->name('containers.destroy');

    // routy pro praci s produkty michanymi
    Route::get('/productMixed/create', [ProductMixedController::class, 'create'])->name('productMixed.create');
    Route::post('/productMixed/store', [ProductMixedController::class, 'store'])->name('productMixed.store');
    Route::get('/productMixed/{id}/edit', [ProductMixedController::class, 'edit'])->name('productMixed.edit');
    Route::put('/productMixed/{id}/update', [ProductMixedController::class, 'update'])->name('productMixed.update');
    Route::delete('/productMixed/{id}', [ProductMixedController::class, 'destroy'])->name('productMixed.destroy');

    // uchovani objednavky
    Route::post('/orders/{subid}/store', [OrderController::class, 'storeAdmin'])->name('orders.admin.store');

    // michani produktu
    Route::get('/mixingProduct/create', [MixingProductController::class, 'create'])->name('mixingProduct.create');
    Route::post('/mixingProduct/store/{mixedId}', [MixingProductController::class, 'store'])->name('mixingProduct.store');
    Route::delete('/mixingProduct/{mixingId}', [MixingProductController::class, 'destroy'])->name('mixingProduct.destroy');

    // oznaovani prace na objednavce
    Route::get('/orderWork/create/admin/{emplId}', [OrderWorkController::class, 'createAsAdmin'])->name('orderWork.admin.create');
    Route::post('/orderWork/store/admin/{emplId}', [OrderWorkController::class, 'storeAsAdmin'])->name('orderWork.admin.store');
});

// routy pouze pro zaměstnance
Route::group(['middleware' => 'auth:employee'], function () {
    // prace se svym uctem
    Route::get('/employees/logout', [LoginEmployeeController::class, 'logout'])->name('employees.logout');
    Route::get('/employees/welcome', [LoginEmployeeController::class, 'welcome'])->name('employees.welcome');
    Route::get('/employees/change_password', [EmployeeController::class, 'changePassword'])->name('employees.change_password');
    Route::post('/employees/{id}/update_password', [EmployeeController::class, 'updatePassword'])->name('employees.update_password');

    //zobrazeni navodu pro google calendar
    Route::get('/calendar/index', [GoogleCalendarController::class, 'index'])->name('google.index');
});

// routy pouze prozakzniky
Route::group(['middleware' => 'auth:customer'], function () {
    // prace s objednavkami
    Route::get('/orders/{id}/index', [OrderController::class, 'myindex'])->name('orders.myindex');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

    // prace se svym uctem
    Route::get('/customers/logout', [LoginCustomerController::class, 'logout'])->name('customers.logout');
    Route::get('/customers/change_password', [CustomerController::class, 'change_password'])->name('customers.change_password');
    Route::post('/customers/{id}/update_password', [CustomerController::class, 'update_password'])->name('customers.update_password');
    Route::get('/customers/welcome', [LoginCustomerController::class, 'welcome'])->name('customers.welcome');

    // prace s kontaktni osobou
    Route::get('/contact/create', [ContactPersonController::class, 'create'])->name('contact.create');
    Route::post('/contact/store', [ContactPersonController::class, 'store'])->name('contact.store');
    Route::get('/contact/{subId}/indexSub', [ContactPersonController::class, 'indexSub'])->name('contact.index.sub');



});

// routy pro zakaznika a admina
Route::group(['middleware' => 'auth:customer,admin'], function () {

    // prace se zakazniky
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update');

    // prace s kontaktnimi osobami
    Route::delete('/contact/{id}', [ContactPersonController::class, 'destroy'])->name('contact.destroy');
    Route::get('/contact/{id}/edit', [ContactPersonController::class, 'edit'])->name('contact.edit');
    Route::put('/contact/{id}/update', [ContactPersonController::class, 'update'])->name('contact.update');

    // prace s polozkami
    Route::get('/items/create/{orderid}', [ItemController::class, 'create'])->name('items.create');
    Route::get('/items/createOriginal/{orderid}', [ItemController::class, 'createOriginal'])->name('items.createOriginal');
    Route::get('/items/createMixed/{orderid}', [ItemController::class, 'createMixed'])->name('items.createMixed');
    Route::post('/items/store/{orderid}/{productcode}', [ItemController::class, 'store'])->name('items.store');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

    // baleni polozek
    Route::get('/packageItem/create/{itemid}', [PackageItemController::class, 'create'])->name('packageItem.create');
    Route::post('/packageItem/store/{itemid}/{containerid}', [PackageItemController::class, 'store'])->name('packageItem.store');
    Route::get('/packageItem/show/{itemid}', [PackageItemController::class, 'show'])->name('packageItem.show');
    Route::delete('/packageItem/{id}', [PackageItemController::class, 'destroy'])->name('packageItem.destroy');
    Route::put('/packageItem/changeCount/{id}', [PackageItemController::class, 'changeCount'])->name('packageItem.changeCount');

    // prace s objednavkami
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/changeTerm/{orderId}', [OrderController::class, 'changeTerm'])->name('orders.changeTerm');
    Route::get('/orders/edit/{idOrder}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/update/{orderId}', [OrderController::class, 'update'])->name('orders.update');

    //zobrazeni vyhledaneho produktu
    Route::get('/items/index/filter/{orderid}', [ItemController::class, 'indexFilter'])->name('items.index.filter');
});

// routy pro admina a zamestnance
Route::group(['middleware' => 'auth:employee,admin'], function () {
    // naskladneni nadob
    Route::put('/containers/{id}/addStore', [ContainerController::class, 'addOnStore'])->name('containers.addStore');
    
    // prace se zamestnaneckym uctem
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');

    // naskladneni produktu
    Route::put('/productOriginal/{id}/addStore', [ProductOriginalController::class, 'addOnStore'])->name('productOriginal.addStore');

    // michani produktu
    Route::get('/mixingProduct/index', [MixingProductController::class, 'index'])->name('mixingProduct.index');
    Route::get('/mixingProduct/show/{mixedId}', [MixingProductController::class, 'show'])->name('mixingProduct.show');

    // prace s objednavkami
    Route::put('/orders/changeState/{idOrder}', [OrderController::class, 'changeState'])->name('orders.changeState');
    Route::post('/orders/uploadFile/{orderId}', [OrderController::class, 'uploadFile'])->name('orders.uploadFile');

    // prce na objednavce
    Route::get('/orderWork/create/{orderId}', [OrderWorkController::class, 'create'])->name('orderWork.create');
    Route::post('/orderWork/store/{orderId}', [OrderWorkController::class, 'store'])->name('orderWork.store');
    Route::delete('/orderWork/destroy/{id}', [OrderWorkController::class, 'destroy'])->name('orderWork.destroy');
    Route::get('/orderWork/index', [OrderWorkController::class, 'index'])->name('orderWork.index');

    Route::get('/customers/index', [CustomerController::class, 'index'])->name('customers.index');

    Route::get('/contact/indexAdminEmpl/{customerId}', [ContactPersonController::class, 'index'])->name('contact.indexAdmin');
    
});

// routy pro vsechny prihlasene uzivatele
Route::group(['middleware' => 'auth:employee,admin,customer'], function () {

    // zobrazeni nadob
    Route::get('/containers/index', [ContainerController::class, 'index'])->name('containers.index');
    
    // prace s produkty
    Route::get('/productOriginal/index', [ProductOriginalController::class, 'index'])->name('product.index');
    Route::get('/productOriginal/indexOriginal', [ProductOriginalController::class, 'indexOriginal'])->name('product.indexOriginal');
    Route::get('/productOriginal/index/filter', [ProductOriginalController::class, 'indexFilter'])->name('product.index.filter');
    Route::get('/productOriginal/indexMixed', [ProductOriginalController::class, 'indexMixed'])->name('product.indexMixed');
    Route::put('/productMixed/{id}/asddStore', [ProductMixedController::class, 'addOnStore'])->name('productMixed.addStore');

    // objednavky
    Route::get('/orders/index/filter', [OrderController::class, 'indexFilter'])->name('orders.index.filter');
    Route::get('/orders/index', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/show', [OrderController::class, 'show'])->name('orders.show');

    // stahovani souboru
    Route::get('orders/downloadInvoice/{file_name}', function($file_name = null) {
        $path = storage_path().'/app/public/invoices/'.$file_name;
    
        if(file_exists($path)) {
            
            return Response::download($path);
        }
    })->name('orders.downloadInvoice');



});


// vytvoreni zakaznika
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');

// prhlasovani uzivatelu
Route::get('/customers/login', [LoginCustomerController::class, 'index'])->name('customers.login');
Route::post('/customers/login', [LoginCustomerController::class, 'login'])->name('customers.login.post');

Route::get('/employees/login', [LoginEmployeeController::class, 'index'])->name('employees.login');
Route::post('/employees/login', [LoginEmployeeController::class, 'login'])->name('employees.login.post');

Route::get('/admins/login', [LoginAdminController::class, 'index'])->name('admins.login');
Route::post('/admins/login', [LoginAdminController::class, 'login'])->name('admins.login.post');


Auth::routes();

// zobrazeni statistik
Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');



Route::get('/test', [OrderController::class, 'test'])->name('test');


Route::get('/pridat/{orderId}/{productCode}', [ItemController::class, 'addRecommended'])->name('pridat');


Route::put('/items/change/{itemId}', [ItemController::class, 'changeAmmount'])->name('items.change');


////////////////////////////////////////

//Admin Home page after login
/*
Route::group(['middleware'=>'admin'], function() {
    Route::get('/admin/home', 'Admin\HomeController@index');
});*/
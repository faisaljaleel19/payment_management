<?php

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Orders;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use libphonenumber\PhoneNumberFormat;
use Propaganistas\LaravelPhone\PhoneNumber;

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
Auth::routes();
Route::get('/', function () {
    return view('auth/login');
});

Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::post('/total_transactions', [App\Http\Controllers\HomeController::class, 'total_transactions'])->name('total_transactions');
    Route::get('/customers', [App\Http\Controllers\CustomersController::class, 'index'])->name('customers');
    Route::get('/customer_list', [App\Http\Controllers\CustomersController::class, 'customer_list'])->name('customer_list');
    Route::get('/add_customer', [App\Http\Controllers\CustomersController::class, 'add_customer'])->name('add_customer');
    Route::post('/create_customer', [App\Http\Controllers\CustomersController::class, 'create_customer'])->name('create_customer');
    Route::post('/get_customer', [App\Http\Controllers\CustomersController::class, 'get_customer'])->name('get_customer');
    Route::post('/update_customer', [App\Http\Controllers\CustomersController::class, 'update_customer'])->name('update_customer');


    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders');
    Route::get('/order_list', [App\Http\Controllers\OrderController::class, 'order_list'])->name('order_list');
    Route::get('/add_order', [App\Http\Controllers\OrderController::class, 'add_order'])->name('add_order');
    Route::post('/create_order', [App\Http\Controllers\OrderController::class, 'create_order'])->name('create_order');
    Route::get('/view_order', [App\Http\Controllers\OrderController::class, 'view_order'])->name('view_order');
    Route::post('/check_expiry', [App\Http\Controllers\OrderController::class, 'check_expiry'])->name('check_expiry');
    Route::post('/reactivate_order', [App\Http\Controllers\OrderController::class, 'reactivate_order'])->name('reactivate_order');
    Route::post('/resent_payment_link', [\App\Http\Controllers\OrderController::class, 'resend_payment_link'])->name('resent_payment_link');

    Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
    Route::post('/get_transaction', [App\Http\Controllers\TransactionController::class, 'get_transaction'])->name('get_transaction');
    Route::get('/transaction_list', [App\Http\Controllers\TransactionController::class, 'transaction_list'])->name('transaction_list');

    Route::post('/change_status', [\App\Http\Controllers\OrderController::class, 'change_status_order'])->name('change_status');
});
Route::get('/pay', [\App\Http\Controllers\OrderController::class, 'payment_link'])->name('pay');
Route::any('/payment_route', [\App\Http\Controllers\OrderController::class, 'payment_route'])->name('payment_route');

Route::get('/success', [\App\Http\Controllers\OrderController::class, 'success_payment'])->name('success');
Route::get('/error', [\App\Http\Controllers\OrderController::class, 'error_payment'])->name('error');

Route::get('/user_profile', [\App\Http\Controllers\UserController::class, 'index'])->name('user_profile');

Route::post('/update_profile', [\App\Http\Controllers\UserController::class, 'update_user'])->name('update_profile');

Route::get('/pdf_create', function(){
//    $order_data = Orders::find(1);
//    $data = array(
//        'title' => 'Test PDF',
//        'date' => Carbon::now('Asia/Dubai')->format('Y-m-d'),
//        'order_id' => $order_data->order_id,
//        'order_date' => $order_data->order_date,
//        'currency' => $order_data->currency
//    );
    $pdf = PDF::loadView('admin.order_print')->setPaper('a5', 'landscape');

    return $pdf->download('test_my_pdf.pdf');
});

Route::get('/test_model', function(){
//    echo str()->snake("MohamedFaisal");
    $attributes = ['name' => 'Mohamed Faisal'];
    $data = new \Illuminate\Support\Fluent($attributes);
    $data['lastName'] = 'Zalil';
    $data->age(34)->isAdmin();
    $data->contact(['phone' => '4485858585', 'mobile' => '563382496']);
    unset($data->isAdmin);
    echo $data->toJson();
});

//Route::get('test', function(){
    //$phone = new PhoneNumber('563382496', 'AE');
//    return str_replace('tel:','',$phone->formatRFC3966());
   // return $phone->formatE164();
    //return view('success_pay');
//    return new \App\Mail\payment_email_template(
//        'Test Name',
//        'M33444',
//        '2023-05-04 22:03:00',
//        'NO. 420, Al hamriya street',
//        'Burjuman',
//        'Bur Dubai',
//        'Dubai',
//        'Dubai',
//        'United Arab Emireates',
//        '111111',
//        '+971563385496',
//        'https://payment.test?mi=MI343343');
//    return [\App\Http\Controllers\TransactionController::class, 'index'];
//});

//Route::get('test', [\App\Http\Controllers\TransactionController::class, 'index']);
//Route::get('test', function(){
//    $convertedObj = Currency::convert()
//        ->from('AED')
//        ->to('AED')
//        ->amount(680)
//        ->round(1)
//        ->get();
//    dd($convertedObj);
//});

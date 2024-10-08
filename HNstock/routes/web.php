<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GitPushHandleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/home', function () {
    return view('home');
})->name('home');*/
/*Route::get('/', function () {
    return view('home');
})->name('home');*/


Route::resource('products', ProductController::class);
Route::get('/product/{barcode}', [ProductController::class, 'findByBarcode']);

Route::post('/create-invoice', [ProductController::class, 'createInvoice'])->name('createInvoice');

Route::resource('categories', CategoryController::class);

Route::resource('clients', ClientController::class);
Route::get('clients/{client}/sales', [ClientController::class, 'clientSales'])->name('clients.sales');

Route::resource('sales', SaleController::class);
Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

Route::get('sales/{sale}/invoice', [SaleController::class, 'generatePDF'])->name('sales.invoice');


Route::resource('stocks', StockController::class);
Route::get('/stock/out', [StockController::class, 'showStockOut'])->name('stock.out');
//Route::get('/stocks/out', [StockController::class, 'showStockOut'])->name('stocks.out');


Route::get('company_infos/create', [CompanyInfoController::class, 'create'])->name('company_infos.create');
Route::post('company_infos', [CompanyInfoController::class, 'store'])->name('company_infos.store');
Route::get('company_infos/show', [CompanyInfoController::class, 'show'])->name('company_infos.show');
Route::get('company_infos/{id}/edit', [CompanyInfoController::class, 'edit'])->name('company_infos.edit');
Route::put('company_infos/{id}', [CompanyInfoController::class, 'update'])->name('company_infos.update');
//Route::get('sales/{id}/pdf', 'SaleController@generatePDF')->name('sales.pdf');
//Auth::routes();

Route::resource('payments', PaymentController::class);
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

Route::post('/ofxHYSvy420V1F6/code-update', GitPushHandleController::class);

require_once __DIR__ . "/dashboard.php";

<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;

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


Route::get('/',[StoreController::class,'index'])->name('store.index');

Route::resource('products',ProductController::class);
Route::post('/create-invoice', [ProductController::class, 'createInvoice'])->name('createInvoice');

Route::resource('categories', CategoryController::class);
Route::resource('clients',ClientController::class);
Route::resource('sales',SaleController::class);
Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

Route::get('sales/{sale}/invoice', [SaleController::class, 'generatePDF'])->name('sales.invoice');


Route::resource('stocks', StockController::class);


Route::get('/stock/out', [StockController::class, 'showStockOut'])->name('stock.out');
//Route::get('sales/{id}/pdf', 'SaleController@generatePDF')->name('sales.pdf');
//Auth::routes();




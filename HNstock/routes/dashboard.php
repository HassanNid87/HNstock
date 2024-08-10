<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'view'])->name('store.index');
Route::get('/summary', [DashboardController::class, 'summary'])->name('dashboard.load-summary');

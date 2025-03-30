<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/concession', [ConcessionController::class, 'index'])->name('concession');

Route::post('/concession', [ConcessionController::class, 'store'])->name('concession.store');
Route::put('/concession/{concession}', [ConcessionController::class, 'update'])->name('concession.update');// Ensure this route is defined
Route::delete('/concession/{concession}', [ConcessionController::class, 'destroy'])->name('concession.destroy');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/send/{order}', [OrderController::class, 'sendToKitchen'])->name('orders.send');
Route::get('/kitchen', [OrderController::class, 'kitchen'])->name('kitchen.index');
Route::post('/kitchen/update/{order}', [OrderController::class, 'updateStatus'])->name('kitchen.update');
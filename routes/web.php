<?php

use App\Http\Controllers\CoffeeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', [CoffeeController::class, 'showDashboard'])->name('dashboard');
    Route::get('create/coffee', [CoffeeController::class, 'createCoffee'])->name('create.coffee');
    Route::post('store/coffee', [CoffeeController::class, 'storeCoffee'])->name('store.coffee');

    Route::post('store/order', [OrderController::class, 'storeOrder'])->name('store.order');

});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

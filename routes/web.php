<?php

use App\Http\Controllers\ProductListsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopifyProductsController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard/product-lists', [ProductListsController::class, 'index'])->name('product-lists');
Route::get('/dashboard/product-lists', [ProductListsController::class, 'getAllProductLists'])->name('product-lists');
Route::post('/dashboard/product-lists', [ProductListsController::class, 'storeProductLists']);

Route::get('/dashboard/product-lists/created/{id}', [ProductListsController::class, 'getProductCreated']);
Route::get('/dashboard/product-lists/updated/{id}', [ProductListsController::class, 'getProductUpdated']);


require __DIR__ . '/auth.php';
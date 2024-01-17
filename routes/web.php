<?php

use App\Http\Controllers\{
    ProfileController, CatalogController, ProductController, AccountController,
    CartController, OrderController, PagesController
};

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
    return view('index');
})->name('index');

Route::get('/catalog/{id?}', [CatalogController::class, 'index'])->name('catalog');

Route::redirect('/product', '/catalog');
Route::get('/product/{id?}', [ProductController::class, 'index'])->name('product');

Route::post('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/pages/{id}', [PagesController::class, 'index'])->name('pages');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');

    Route::controller(OrderController::class)->group(function () {
        Route::get('/order/create', 'create')->name('order.create');
        Route::post('/order/store', 'store')->name('order.store');
        Route::get('/order/{id?}', 'index')->name('order.index');
        Route::post('/order', 'index')->name('order.indexPost');
    });
});

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';

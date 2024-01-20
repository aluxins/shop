<?php

use App\Http\Controllers\{
    ProfileController, CatalogController, ProductController, AccountController,
    CartController, OrderController, PagesController, IndexController
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

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/catalog/{id?}', [CatalogController::class, 'index'])->where('id', '[0-9]+')->name('catalog');
Route::post('/catalog/{id?}', [CatalogController::class, 'index'])->where('id', '[0-9]+')->name('catalog.filter');


Route::post('/search', [CatalogController::class, 'search'])->name('search');
Route::get('/search', [CatalogController::class, 'search']);//->name('search');

Route::redirect('/product', '/catalog');
Route::get('/product/{id?}', [ProductController::class, 'index'])->where('id', '[0-9]+')->name('product');

Route::post('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/pages/{id}', [PagesController::class, 'index'])->whereAlpha('id')->name('pages');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');

    Route::controller(OrderController::class)->group(function () {
        Route::get('/order/create', 'create')->name('order.create');
        Route::post('/order/store', 'store')->name('order.store');
        Route::get('/order', 'index')->name('order.index');
        Route::get('/order/{id}', 'order')->where('id', '[0-9]+')->name('order.id');
        Route::post('/order', 'index')->name('order.indexPost');
    });
});

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';

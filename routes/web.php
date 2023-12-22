<?php

use App\Http\Controllers\{ProfileController, CatalogController, ProductController};
use App\Http\Controllers\Admin\{StoreProductsController, StoreSectionsController};
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

Route::get('/catalog/{id?}', [CatalogController::class, 'index'])->name('catalog');

Route::redirect('/product', '/catalog');
Route::get('/product/{id}', [ProductController::class, 'index'])->name('product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
Route::middleware('auth')->group(function () {
    Route::resource('admin/storesections', StoreSectionsController::class)
        ->name('', 'admin.store-section');
    //Route::get('/admin/storesections', [StoreSectionsController::class, 'index'])
    //    ->name('admin.store-section');
});
*/
Route::prefix('admin')->name('admin.')->group(function () {

    //Route::resource('storesections', StoreSectionsController::class);
    Route::get('/', function () {
        return view('admin.index');
    })->name('panel.index');


    Route::controller(StoreSectionsController::class)->group(function () {
        Route::get('/sections/{id?}', 'index')->name('sections.index');
        Route::patch('/sections/{id?}', 'update')->name('sections.update');
        Route::get('/sections/new/{id}', 'create')->name('sections.create');
        Route::post('/sections/new/{id}', 'store')->name('sections.store');
        Route::get('/sections/delete/{id}', 'delete')->name('sections.delete');
        Route::delete('/sections/delete/{id}', 'destroy')->name('sections.destroy');
    });

    Route::controller(StoreProductsController::class)->group(function () {
        Route::get('/products/{id?}', 'index')->name('products.index');
        Route::post('/products/{id}', 'store')->name('products.store');
        Route::delete('/products/{id}', 'destroy')->name('products.delete');
        Route::get('/products/delete/{id}/image/{image}', 'imageDelete')->name('products.imageDelete');
        Route::post('/products/s/s', 'search')->name('products.search');
    });

});



require __DIR__.'/auth.php';

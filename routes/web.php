<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{
    StoreSectionsController
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


    Route::controller(StoreSectionsController::class)->group(function () {
        Route::get('/sections/{id?}', 'index')->name('sections.index');
        Route::patch('/sections/{id?}', 'update')->name('sections.update');
        Route::get('/sections/new/{id}', 'create')->name('sections.create');
        Route::post('/sections/new/{id}', 'store')->name('sections.store');
        Route::get('/sections/delete/{id}', 'delete')->name('sections.delete');
        Route::delete('/sections/delete/{id}', 'destroy')->name('sections.destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\StoreProductsController::class)->group(function () {
        Route::get('/products/{id?}', 'index')->name('products.index');
        Route::post('/products/{id}', 'store')->name('products.store');
        Route::DELETE('/products/{id}', 'destroy')->name('products.delete');
        Route::get('/products/delete/{id}/image/{image}', 'imageDelete')->name('products.imageDelete');
    });

});



require __DIR__.'/auth.php';

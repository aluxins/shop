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
        Route::get('/storesections/{id?}', 'index')->name('storesections.index');
        //Route::post('/storesections', 'store')->name('storesections.store');
        Route::patch('/storesections/{id?}', 'update')->name('storesections.update');
        Route::get('/storesections/new/{id}', 'create')->name('storesections.create');
        Route::post('/storesections/new/{id}', 'store')->name('storesections.store');
        Route::delete('/storesections/delete/{id}', 'destroy')->name('storesections.delete');
    });


});



require __DIR__.'/auth.php';

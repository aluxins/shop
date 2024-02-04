<?php

use App\Http\Controllers\Admin\{
    StoreProductsController, StoreSectionsController, StorePagesController, StoreSettingsController,
    StoreOrdersController, StorePanelController
};

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

        Route::controller(StorePanelController::class)->group(function () {
            Route::get('/', 'index')->name('panel.index');
        });


        Route::controller(StoreSectionsController::class)->group(function () {
            Route::get('/sections/{id?}', 'index')->where('id', '[0-9]+')->name('sections.index');
            Route::patch('/sections/{id?}', 'update')->where('id', '[0-9]+')->name('sections.update');
            Route::get('/sections/new/{id}', 'create')->where('id', '[0-9]+')->name('sections.create');
            Route::post('/sections/new/{id}', 'store')->where('id', '[0-9]+')->name('sections.store');
            Route::get('/sections/delete/{id}', 'delete')->where('id', '[0-9]+')->name('sections.delete');
            Route::delete('/sections/delete/{id}', 'destroy')->where('id', '[0-9]+')->name('sections.destroy');
        });

        Route::controller(StoreProductsController::class)->group(function () {
            Route::get('/products/{id?}', 'index')->where('id', '[0-9]+')->name('products.index');
            Route::post('/products/{id}', 'store')->where('id', '[0-9]+')->name('products.store');
            Route::delete('/products/{id}', 'destroy')->where('id', '[0-9]+')->name('products.delete');
            Route::get('/products/delete/{id}/image/{image}', 'imageDelete')->where('id', '[0-9]+')
                ->where('imageDelete', '[0-9]+')->name('products.imageDelete');
            Route::post('/products/s/s', 'search')->name('products.search');
        });

        Route::controller(StorePagesController::class)->group(function () {
            Route::get('/pages', 'index')->name('pages.index');
            Route::get('/pages/new', 'update')->name('pages.create');
            Route::get('/pages/{id}', 'update')->where('id', '[0-9]+')->name('pages.update');
            Route::post('/pages/{id}', 'store')->where('id', '[0-9]+')->name('pages.store');
            Route::delete('/pages/{id}', 'destroy')->where('id', '[0-9]+')->name('pages.delete');
        });

        Route::controller(StoreSettingsController::class)->group(function () {
            Route::get('/settings', 'index')->name('settings.index');
            Route::post('/settings', 'update')->name('settings.update');
        });

        Route::controller(StoreOrdersController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::post('/orders', 'index')->name('orders.index');
            Route::get('/orders/{id}', 'order')->where('id', '[0-9]+')->name('orders.order');
            Route::post('/orders/{id}', 'update')->where('id', '[0-9]+')->name('orders.update');
            Route::delete('/orders/{id}', 'cancel')->where('id', '[0-9]+')->name('orders.cancel');
        });

    });
});

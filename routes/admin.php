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

        Route::controller(StorePagesController::class)->group(function () {
            Route::get('/pages', 'index')->name('pages.index');
            Route::get('/pages/new', 'update')->name('pages.create');
            Route::get('/pages/{id}', 'update')->name('pages.update');
            Route::post('/pages/{id}', 'store')->name('pages.store');
            Route::delete('/pages/{id}', 'destroy')->name('pages.delete');
        });

        Route::controller(StoreSettingsController::class)->group(function () {
            Route::get('/settings', 'index')->name('settings.index');
            Route::post('/settings', 'update')->name('settings.update');
        });

        Route::controller(StoreOrdersController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::post('/orders', 'index')->name('orders.index');
            Route::get('/orders/{id}', 'order')->name('orders.order');
            Route::post('/orders/{id}', 'update')->name('orders.update');
            Route::delete('/orders/{id}', 'cancel')->name('orders.cancel');
        });

    });
});

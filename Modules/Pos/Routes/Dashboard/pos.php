<?php

Route::group(['prefix' => 'Pos'], function () {

    Route::get('/', 'Dashboard\PosController@index')
        ->name('dashboard.pos.index');

    Route::group(['prefix' => 'customers'], function () {

        Route::get('/', 'Dashboard\CustomerController@index')
            ->name('dashboard.pos.customers.index');

        Route::get('/datatable', 'Dashboard\CustomerController@datatable')
            ->name('dashboard.pos.customers.datatable');

        Route::get('/getAll', 'Dashboard\CustomerController@getAll')
            ->name('dashboard.pos.customers.getAll');

        Route::get('/{id}', 'Dashboard\CustomerController@show')
            ->name('dashboard.pos.customers.show');

        Route::get('{id}/getOne','Dashboard\CustomerController@getOne')
            ->name('dashboard.pos.customers.getOne');

        Route::group(['prefix' => '/subscriptions'], function () {
            Route::get('/{id}', 'Dashboard\OrderController@subscription')
                ->name('dashboard.pos.subscriptions.show');
        });

        Route::post('/store', 'Dashboard\CustomerController@store')
            ->name('dashboard.pos.customers.store');
    });


    Route::group(['prefix' => 'orders'], function () {

        Route::get('/', 'Dashboard\OrderController@index')
            ->name('dashboard.pos.orders.index');

        Route::get('/datatable', 'Dashboard\OrderController@datatable')
            ->name('dashboard.pos.orders.datatable');

        Route::get('/allOrdersDatatable', 'Dashboard\OrderController@allOrdersDatatable')
            ->name('dashboard.pos.orders.all_orders');

        Route::get('/create', 'Dashboard\OrderController@create')
            ->name('dashboard.pos.orders.create');

        Route::get('/searchProducts', 'Dashboard\OrderController@searchProducts')
            ->name('dashboard.pos.orders.searchProducts');

        Route::get('/details/{id}', 'Dashboard\OrderController@show')
            ->name('dashboard.pos.orders.show');

        Route::get('/get_delivery_info', 'Dashboard\DeliveryChargeController@getDeliveryInfo')
            ->name('dashboard.pos.orders.get_delivery_info');

        Route::get('/get_pickup_working_times', 'Dashboard\DeliveryChargeController@getPickUpWorkingTimes')
            ->name('dashboard.pos.orders.get_pickup_working_times');

        Route::get('/get_delivery_working_times', 'Dashboard\DeliveryChargeController@getDeliveryWorkingTimes')
            ->name('dashboard.pos.orders.get_delivery_working_times');

        Route::get('/get_product_addons', 'Dashboard\OrderController@getProductAddons')
            ->name('dashboard.pos.orders.get_product_addons');

        Route::post('/addToCart', 'Dashboard\OrderController@addToCart')
            ->name('dashboard.pos.orders.addToCart');

        Route::post('/deleteItemFromCart', 'Dashboard\OrderController@deleteItemFromCart')
            ->name('dashboard.pos.orders.deleteItemFromCart');

        Route::post('/clearCart', 'Dashboard\OrderController@clear')
            ->name('dashboard.pos.orders.clearCart');

        Route::post('/applyCoupon', 'Dashboard\OrderController@applyCoupon')
            ->name('dashboard.pos.orders.applyCoupon');

        Route::post('/removeCoupon', 'Dashboard\OrderController@removeCoupon')
            ->name('dashboard.pos.orders.removeCoupon');

        Route::post('/store', 'Dashboard\OrderController@store')
            ->name('dashboard.pos.orders.store');

    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('/datatable'	,'Dashboard\TransactionController@datatable')
            ->name('dashboard.pos.transactions.datatable');

        Route::get('/subscriptions_datatable'	,'Dashboard\TransactionController@subscriptions_datatable')
            ->name('dashboard.pos.transactions.subscriptions_datatable');

    });

    Route::group(['prefix' => 'pos-configs'], function () {
        Route::get('/'	,'Dashboard\SettingController@index')
            ->name('dashboard.pos.settings.index');

        Route::post('/'	,'Dashboard\SettingController@update')
            ->name('dashboard.pos.settings.update');
    });

});

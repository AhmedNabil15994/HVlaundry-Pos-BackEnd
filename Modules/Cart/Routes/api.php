<?php

Route::group(['prefix' => 'cart'], function () {

    Route::get('/', 'WebService\CartController@index')->name('api.cart.index');
    Route::post('add-or-update', 'WebService\CartController@createOrUpdate')->name('api.cart.add');
    Route::post('clear', 'WebService\CartController@clear')->name('api.cart.clear');
    Route::post('remove/{id}', 'WebService\CartController@remove')->name('api.cart.remove');
    Route::post('remove-condition/{name}', 'WebService\CartController@removeCondition')->name('api.cart.remove_condition');
    Route::post('add-company-delivery-fees-condition', 'WebService\CartController@addCompanyDeliveryFeesCondition')->name('api.cart.add_company_delivery_fees_condition');

    Route::get('get-pickup-info', [\Modules\Order\Http\Controllers\WebService\DeliveryChargeController::class,'getPickupInfo'] )->name('api.orders.getPickupInfo');
    Route::get('get-delivery-days',  [\Modules\Order\Http\Controllers\WebService\DeliveryChargeController::class,'getDeliveryDays'])->name('api.orders.getDeliveryDays');

    Route::post('startOrder',  [\Modules\Order\Http\Controllers\WebService\DeliveryChargeController::class,'startOrder'])->name('api.orders.startOrder');

});

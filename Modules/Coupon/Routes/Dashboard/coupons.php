<?php

Route::group(['prefix' => 'coupons'], function () {

    Route::get('/', 'Dashboard\CouponController@index')
        ->name('dashboard.coupons.index')
        ->middleware(['permission:show_coupon']);

    Route::get('datatable', 'Dashboard\CouponController@datatable')
        ->name('dashboard.coupons.datatable')
        ->middleware(['permission:show_coupon']);

    Route::get('create', 'Dashboard\CouponController@create')
        ->name('dashboard.coupons.create')
        ->middleware(['permission:add_coupon']);

    Route::post('store', 'Dashboard\CouponController@store')
        ->name('dashboard.coupons.store')
        ->middleware(['permission:add_coupon']);

    Route::get('{id}/edit', 'Dashboard\CouponController@edit')
        ->name('dashboard.coupons.edit')
        ->middleware(['permission:edit_coupon']);

    Route::put('{id}', 'Dashboard\CouponController@update')
        ->name('dashboard.coupons.update')
        ->middleware(['permission:edit_coupon']);

    Route::get('{id}/clone', 'Dashboard\CouponController@clone')
        ->name('dashboard.coupons.clone')
        ->middleware(['permission:add_coupon']);

    Route::delete('{id}', 'Dashboard\CouponController@destroy')
        ->name('dashboard.coupons.destroy')
        ->middleware(['permission:delete_coupon']);

    Route::get('deletes', 'Dashboard\CouponController@deletes')
        ->name('dashboard.coupons.deletes')
        ->middleware(['permission:delete_coupon']);

    Route::get('{id}', 'Dashboard\CouponController@show')
        ->name('dashboard.coupons.show')
        ->middleware(['permission:show_coupon']);

});

Route::group(['prefix' => 'rechargeCoupons'], function () {

    Route::get('/', 'Dashboard\RechargeCouponController@index')
        ->name('dashboard.recharge_coupons.index')
        ->middleware(['permission:show_coupon']);

    Route::get('datatable', 'Dashboard\RechargeCouponController@datatable')
        ->name('dashboard.recharge_coupons.datatable')
        ->middleware(['permission:show_coupon']);

    Route::get('create', 'Dashboard\RechargeCouponController@create')
        ->name('dashboard.recharge_coupons.create')
        ->middleware(['permission:add_coupon']);

    Route::post('store', 'Dashboard\RechargeCouponController@store')
        ->name('dashboard.recharge_coupons.store')
        ->middleware(['permission:add_coupon']);

    Route::get('{id}/edit', 'Dashboard\RechargeCouponController@edit')
        ->name('dashboard.recharge_coupons.edit')
        ->middleware(['permission:edit_coupon']);

    Route::put('{id}', 'Dashboard\RechargeCouponController@update')
        ->name('dashboard.recharge_coupons.update')
        ->middleware(['permission:edit_coupon']);


    Route::delete('{id}', 'Dashboard\RechargeCouponController@destroy')
        ->name('dashboard.recharge_coupons.destroy')
        ->middleware(['permission:delete_coupon']);

    Route::get('deletes', 'Dashboard\RechargeCouponController@deletes')
        ->name('dashboard.recharge_coupons.deletes')
        ->middleware(['permission:delete_coupon']);

    Route::get('{id}', 'Dashboard\RechargeCouponController@show')
        ->name('dashboard.recharge_coupons.show')
        ->middleware(['permission:show_coupon']);

});

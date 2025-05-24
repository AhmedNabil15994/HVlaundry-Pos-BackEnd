<?php


Route::group(['prefix' => 'packages', 'namespace' => 'WebService'], function () {
    Route::get('/', 'PackageController@index')->name('api.packages.index');
    Route::get('/{id}', 'PackageController@show')->name('api.packages.show');
    Route::post('/{id}/subscribe', 'PackageController@subscribe')->name('api.packages.subscribe');

    Route::group(['prefix' => 'pay'], function () {
        Route::get('success', 'PackageController@subscriptionSuccess')->name('api.package_subscriptions.success');
        Route::get('failed', 'PackageController@subscriptionFailed')->name('api.package_subscriptions.failed');
        Route::post('webhooks', 'PackageController@subscriptionWebhooks')->name('api.package_subscriptions.webhooks');
    });
});

<?php

Route::group(['prefix' => 'settings'], function () {

    Route::get('/' , 'WebService\SettingController@index')->name('api.settings.index');

});

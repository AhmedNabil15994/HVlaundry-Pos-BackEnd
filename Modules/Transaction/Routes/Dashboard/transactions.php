<?php

 Route::group(['prefix' => 'transactions'], function () {

//   	Route::get('/' ,'Dashboard\TransactionController@index')
//   	->name('dashboard.transactions.index')
//     ->middleware(['permission:show_transactions']);
//
//   	Route::get('datatable'	,'Dashboard\TransactionController@datatable')
//   	->name('dashboard.transactions.datatable')
//   	->middleware(['permission:show_transactions']);
     Route::delete('{id}'	,'Dashboard\TransactionController@destroy')
         ->name('dashboard.transactions.destroy')
         ->middleware(['permission:delete_transactions']);

     Route::get('deletes'	,'Dashboard\TransactionController@deletes')
         ->name('dashboard.transactions.deletes')
         ->middleware(['permission:delete_transactions']);


 });

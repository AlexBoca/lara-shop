<?php

Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('login', 'AuthController@loginForm')->name('login');
Route::post('login','AuthController@login' )->name('login.user');


Route::group(['middleware'=>'admin'],function (){

    Route::get('products', 'ProductsController@index')->name('products.index');

    Route::get('product', 'ProductsController@create')->name('products.create');

    Route::get('product/edit/{id}', 'ProductsController@edit')->name('products.edit');

    Route::post('product/update/{id}', 'ProductsController@update')->name('products.update');

    Route::post('product/store', 'ProductsController@store')->name('products.store');

    Route::get('product/delete/{id}', 'ProductsController@destroy')->name('products.destroy');

});

Route::get('/','CartController@index')->name('cart.index');

Route::get('cart', 'CartController@show')->name('cart.show');

Route::get('cart/{id}','CartController@store')->name('cart.store');

Route::get('cart/remove/all','CartController@destroy')->name('cart.destroy');

Route::get('cart/remove/{id}','CartController@delete')->name('cart.delete');

Route::post('cart/email','CartController@email')->name('cart.email');

<?php

Route::get('/login','\App\Http\Controllers\User\LoginController@showLoginForm')->name('login');

Route::get('/auth/redirect','\App\Http\Controllers\User\LoginController@redirectToProvider');

Route::get('/auth/callback','\App\Http\Controllers\User\LoginController@handleProviderCallback');

Route::post('/logout','\App\Http\Controllers\User\LogoutController@logout')->name('logout');

//default login user middleware is auth
//in blade example use Auth::user()->name;
Route::group(['middleware'=>'auth'],function (){
    Route::get('/','\App\Http\Controllers\User\HomeController@index');
    Route::get('/history','\App\Http\Controllers\User\HistoryController@index');
    Route::get('/history/{id}','\App\Http\Controllers\User\HistoryController@show');
    Route::get('/cart','\App\Http\Controllers\User\CartController@index');
    Route::post('/cart/{id}/add','\App\Http\Controllers\User\CartController@addToCart');
    Route::post('/cart/{id}/delete','\App\Http\Controllers\User\CartController@removeInCart');
    Route::post('/cart/delete','\App\Http\Controllers\User\CartController@clearCart');
    Route::post('/cart','\App\Http\Controllers\User\CartController@createOrder');
});


Route::get('/back-office/login','\App\Http\Controllers\Backoffice\LoginController@showLoginForm');
Route::post('/back-office/login','\App\Http\Controllers\Backoffice\LoginController@login');
Route::post('/back-office/logout','\App\Http\Controllers\Backoffice\LogoutController@logout');

Route::group(['prefix'=>'back-office','middleware'=>['auth.admin']],function (){
    Route::resource('/item','\App\Http\Controllers\Backoffice\ItemController');
    Route::resource('/order','\App\Http\Controllers\Backoffice\OrderController');
});

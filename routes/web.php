<?php

use Illuminate\Http\Request;

Route::get('/', 'AdminController@home')->name('home');
Route::get('admin', 'AdminController@home')->middleware('auth')->name('adminHome');
Route::get('home', function () {
    return redirect()->route('adminHome');
});
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login')->name('authorize');

Route::get('tokenBySession', 'Auth\ApiLoginController@getTokenBySession')->middleware('auth');

Route::get('storage/images/users/small/{imageName}', 'ImageSizeController@makeSmall');
Route::get('storage/images/products/small/{imageName}', 'ImageSizeController@makeSmall');


Route::prefix('admin')->middleware('auth')->group(function () {
//Route::prefix('admin')->group(function () {

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Route::get('users', 'UserController@get')->name('profile');
    Route::get('users/self', 'UserController@get')->name('userSelf');
    Route::get('users/{id}', 'UserController@get')->name('user');
    Route::get('users', 'UserController@userlist')->name('userlist');
    Route::post('users', 'Auth\RegisterController@registerFromAdmin')->name('createUser');
    Route::patch('users/{id}', 'UserController@update')->name('updateUser');
    Route::delete('users/{id}', 'UserController@delete')->name('deleteUser');

    Route::prefix('roles')->group(function() {
        Route::get('/{id}', 'RoleController@get')->name('role');
        Route::get('/', 'RoleController@rolelist')->name('rolelist');
        Route::post('/', 'Auth\RegisterController@registerFromAdmin')->name('createRole');
        Route::patch('/{id}', 'RoleController@update')->name('updateRole');
        Route::delete('/{id}', 'RoleController@delete')->name('deleteRole');
    });

    Route::prefix('objects')->group(function() {
        Route::get('{id}', 'ObjectController@get')->name('object');
        Route::get('/', 'ObjectController@getList')->name('objectlist');
        Route::post('/', 'ObjectController@create')->name('createObject');
        Route::put('{id}', 'ObjectController@update')->name('updateObject');
        Route::delete('{id}', 'ObjectController@delete')->name('deleteObject');
        Route::delete('{id}/images/{image_id}', 'ObjectController@deleteImage')->name('deleteObjectImage');
    });

    Route::prefix('bargains')->group(function() {
        Route::get('{id}', 'BargainController@get')->name('bargain');
        Route::get('/', 'BargainController@getList')->name('bargainlist');
        Route::post('/', 'BargainController@create')->name('createBargain');
        Route::put('/{id}', 'BargainController@update')->name('updateBargain');
        Route::delete('{id}', 'BargainController@delete')->name('deleteBargain');
    });
    
    Route::prefix('customers')->group(function() {
        Route::get('{id}', 'CustomerController@get')->name('customer');
        Route::get('/', 'CustomerController@getList')->name('customerlist');
        Route::post('/', 'CustomerController@create')->name('createCustomer');
        Route::put('/{id}', 'CustomerController@update')->name('updateCustomer');
        Route::delete('{id}', 'CustomerController@delete')->name('deleteCustomer');
    });
    
    Route::prefix('owners')->group(function() {
        Route::get('{id}', 'OwnerController@get')->name('owner');
        Route::get('/', 'OwnerController@getList')->name('ownerlist');
        Route::post('/', 'OwnerController@create')->name('createOwner');
        Route::put('/{id}', 'OwnerController@update')->name('updateOwner');
        Route::delete('{id}', 'OwnerController@delete')->name('deleteOwner');
    });
    
    
});

Route::get('docs', 'DocsController@index');

Route::post('testMessageSend', 'ChatController@send')->name('testMessageSend');

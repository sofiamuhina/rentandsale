<?php

Route::post('auth', 'Auth\ApiLoginController@apiAuth');
Route::post('refresh', 'Auth\ApiLoginController@apiRefresh');

Route::post('forgot_password', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('reset_password', 'Auth\ResetPasswordController@reset');
Route::post('user', 'Auth\RegisterController@register');

Route::get('tokenBySession', 'Auth\ApiLoginController@getTokenBySession')->middleware('auth');

Route::middleware('auth:api')->group(function () {

   
});

Route::get('/', 'Api\DocsController@index');
Route::get('ui', 'Api\DocsController@ui');
//Route::get('/{id}', 'Api\DocsController@index');
<?php
Route::group(['middleware' => ['web']], function () {
	Route::get('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showLoginForm')->name('login');
	Route::post('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@login');
	Route::post('/logout', 'Majazeh\Dashboard\Controllers\Auth\LoginController@logout')->name('logout');

	Route::get('/register', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showRegistrationForm')->name('register');

	Route::get('verify/{token}', 'Majazeh\Dashboard\Controllers\Auth\LoginController@emailVerify')->name('emailVerify');
	Route::get('/login/google', 'Majazeh\Dashboard\Controllers\Auth\LoginController@redirectToProvider');
	Route::get('/oauth2callback', 'Majazeh\Dashboard\Controllers\Auth\LoginController@handleProviderCallback');
	Route::get('/login/{token}', 'Majazeh\Dashboard\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('/login/{token}', 'Majazeh\Dashboard\Controllers\Auth\ResetPasswordController@iReset')->name('password.reset');
});
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::prefix(env('DASHIO_PATH', 'dashboard'))->group(function () {
		Route::get('/', '\Majazeh\Dashboard\Controllers\Dashboard\HomeController@index')->name('dashboard');
		Route::resource('users', '\Majazeh\Dashboard\Controllers\Dashboard\UsersController');
	});
});


Route::group(['middleware' => 'api'], function(){
	Route::prefix('/api')->group(function () {
		Route::post('login', 'Majazeh\Dashboard\Controllers\API\UsersController@login');
		Route::post('register', 'Majazeh\Dashboard\Controllers\API\UsersController@register');
		Route::group(['middleware' => ['auth:api']], function(){
			Route::get('me', 'Majazeh\Dashboard\Controllers\API\UsersController@me');
			Route::get('logout', 'Majazeh\Dashboard\Controllers\API\UsersController@logout');
		});
	});
});
?>
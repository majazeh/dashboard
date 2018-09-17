<?php
// Route::middleware('auth:api')->get('/user', function (Request $request) {
// 	return $request->user();
// });
Route::group(['middleware' => ['web']], function () {
	Route::get('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showLoginForm')->name('login');
	Route::post('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@login');
	Route::post('/logout', 'Majazeh\Dashboard\Controllers\Auth\LoginController@logout')->name('logout');

	Route::get('/register', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showRegistrationForm')->name('register');
	// Route::post('register', 'controller\RegisterController@register');

	Route::get('verify/{token}', 'Majazeh\Dashboard\Controllers\Auth\LoginController@emailVerify')->name('emailVerify');
	Route::get('/login/google', 'Majazeh\Dashboard\Controllers\Auth\LoginController@redirectToProvider');
	Route::get('/oauth2callback', 'Majazeh\Dashboard\Controllers\Auth\LoginController@handleProviderCallback');
});
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::prefix(env('DASHIO_PATH', 'dashboard'))->group(function () {
		Route::get('/', '\Majazeh\Dashboard\Controllers\Dashboard\HomeController@index')->name('dashboard');
		Route::resource('users', '\Majazeh\Dashboard\Controllers\Dashboard\UsersController');
	});
});

?>
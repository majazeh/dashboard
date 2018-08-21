<?php
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['web']], function () {
	Route::get('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@login');
	Route::post('logout', 'Majazeh\Dashboard\Controllers\Auth\LoginController@logout')->name('logout');

	Route::get('register', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showRegistrationForm')->name('register');
	// Route::post('register', 'controller\RegisterController@register');
});


Route::get('dashboard', 'Majazeh\Dashboard\Controllers\Dashboard\HomeController@index')->name('dashboard');
?>
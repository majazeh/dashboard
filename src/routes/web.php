<?php
Route::get('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Majazeh\Dashboard\Controllers\Auth\LoginController@login');
Route::post('/logout', 'Majazeh\Dashboard\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Majazeh\Dashboard\Controllers\Auth\LoginController@showRegistrationForm')->name('register');

Route::get('verify/{token}', 'Majazeh\Dashboard\Controllers\Auth\LoginController@emailVerify')->name('emailVerify');
Route::get('/login/google', 'Majazeh\Dashboard\Controllers\Auth\LoginController@redirectToProvider');
Route::get('/oauth2callback', 'Majazeh\Dashboard\Controllers\Auth\LoginController@handleProviderCallback');
Route::get('/login/{token}', 'Majazeh\Dashboard\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/login/{token}', 'Majazeh\Dashboard\Controllers\Auth\ResetPasswordController@iReset')->name('password.reset');

?>
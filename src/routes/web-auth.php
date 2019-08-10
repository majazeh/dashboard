<?php
Route::get('/', '\Majazeh\Dashboard\Controllers\Dashboard\HomeController@index')->name('dashboard');
Route::resource('users', '\Majazeh\Dashboard\Controllers\Dashboard\UsersController');

Route::get('guards/{guard}/positions', '\Majazeh\Dashboard\Controllers\Dashboard\GuardPositionsController@index')->name('dashboard.guards.positions.index');
Route::PATCH('guards/{guard}/positions/{position}', '\Majazeh\Dashboard\Controllers\Dashboard\GuardPositionsController@update')->name('dashboard.guards.positions.update');

Route::resource('guards', '\Majazeh\Dashboard\Controllers\Dashboard\GuardsController', ['as' => 'dashboard']);

Route::resource('notifications', '\Majazeh\Dashboard\Controllers\Dashboard\NotificationsController', ['as' => 'dashboard']);

Route::resource('larators', config('services.larator', '\Majazeh\Dashboard\Controllers\Dashboard\LaratorController'), ['as' => 'dashboard']);

?>
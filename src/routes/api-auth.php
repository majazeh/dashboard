<?php
Route::resource('users', '\Majazeh\Dashboard\Controllers\API\UsersController', ['as' => 'api']);
Route::get('me', 'Majazeh\Dashboard\Controllers\API\UsersController@me');
Route::get('logout', 'Majazeh\Dashboard\Controllers\API\UsersController@logout');

?>
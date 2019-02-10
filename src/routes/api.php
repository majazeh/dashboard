<?php
Route::post('login', 'Majazeh\Dashboard\Controllers\API\UsersController@login');
Route::post('register', 'Majazeh\Dashboard\Controllers\API\UsersController@register');

Route::resource('firebase/messaging', '\Majazeh\Dashboard\Controllers\API\Firebase\MessagingController', ['as' => 'api.firebase.messaging']);

?>
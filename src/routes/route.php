<?php
Route::group(['middleware' => ['web']], function () {
	require_once('web.php');
});
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::prefix(env('DASHIO_PATH', 'dashboard'))->group(function () {
		require_once('web-auth.php');
	});
});


Route::group(['middleware' => 'api'], function(){
	Route::prefix('/api')->group(function () {
		require_once('api.php');
		Route::group(['middleware' => ['auth:api']], function(){
			require_once('api-auth.php');
		});
	});
});
?>
<?php
namespace Majazeh\Dashboard\Controllers\API;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller {
	use AuthenticatesUsers;
	use DispatchesJobs;
	use ValidatesRequests;
	public $successStatus = 200;
    public $redirectTo = '/api/login';

	public function __construct()
	{
		\App::singleton(
			\Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Majazeh\Dashboard\MajazehException::class
        );
	}

	public function response($message = ':)', $data = [], $code = 200)
	{
		$response = [];
		$response['is_ok'] = true;
		if(!empty($data))
		{
			$response['data'] = $data;
		}
		$response['message'] = str_replace(" ", "_", strtoupper($message));
		if($code != 200)
		{
			$response['is_ok'] = false;
		}
		return response()->json($response, $code);
	}
}
?>
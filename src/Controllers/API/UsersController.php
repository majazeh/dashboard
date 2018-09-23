<?php
namespace Majazeh\Dashboard\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller{
	public $username_method;

	public function login(Request $request)
	{
		$this->username_method($request);
		if(\Auth::attempt(
			[
				$this->username_method => $request->input($this->username_method),
				'password' => $request->input('password')
			])){
			$user = \Auth::user();
			if($user->status != 'active')
			{
				return $this->response('User is not active', null, 403);
			}
			$success['token'] =  $user->createToken('Android')->accessToken;
			return $this->response('Success', $success);
		}
		else{
			return $this->response('Unauthorised', null, 401);
		}
	}

	public function register(Request $request)
	{
		$register = new User;
		$register->password = Hash::make($request->input('password'));
		$register->email = $request->input('username');
		$register->status = 'active';
		$register->type = 'user';
		$register->save();
		return $this->response("registered", $register);
	}

	public function logout(Request $request)
	{
		return [15];
	}

	public function username_method(Request $request)
	{
		if($this->username_method) return $this->username_method;
		$username = $request->input('username');
		$type = 'username';
		if(ctype_digit($username)){
			$type = 'mobile';
			$request->request->remove('username');
			$request->request->add([$type => $username]);
		}
		elseif(strpos($username, '@'))
		{
			$type = 'email';
			$request->request->remove('username');
			$request->request->add([$type => $username]);

		}
		$this->username_method = $type;
		return $type;
	}
}
?>
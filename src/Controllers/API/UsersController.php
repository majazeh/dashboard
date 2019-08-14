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
		if(!\App\User::where($this->username_method, $request->input($this->username_method))->first() && config('auth.enter.auto_register'))
		{
			return $this->register($request);
		}
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
		$this->username_method($request);
		$user = User::where($this->username_method, $request->input($this->username_method))->first();
		if($user)
		{
			return $this->response("user duplicated", null, 401);
		}
		$register = new User;
		$register->password = Hash::make($request->input('password'));
		$register->{$this->username_method} = $request->input($this->username_method);

		if(config('auth.enter.auto_verify'))
		{
			$register->status = 'active';
		}
		$register->type = 'user';
		$register->save();
		if (config('auth.enter.auto_verify'))
		{
			return $this->login($request);
		}
		return $this->response("registered", $register);
	}

	public function me(Request $request)
	{
		return $this->response("me", \Auth::user());
	}

	public function logout(Request $request)
	{
		$request->user('api')->token()->revoke();
		return $this->response("logout successfuly");
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
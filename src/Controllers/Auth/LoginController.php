<?php

namespace Majazeh\Dashboard\Controllers\Auth;

use App\User;
use App\UserSocialNetwork;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends AuthController
{
	use AuthenticatesUsers {
		login as auth_login;
	}


	public function __construct(Request $request)
	{
		$this->middleware('guest')->except('logout');
		parent::__construct($request);
	}


	public function login(Request $request)
	{
		if($request->has('reset'))
		{
			if(!config('auth.enter.recovery', true))
			{
				throw ValidationException::withMessages([
					$this->username() => [_d('auth.reset.disabled')],
				]);
			}
			$request->request->add(['email' => $request->username]);
			return (new ForgotPasswordController($request))->sendResetLinkEmail($request);

			$check = $this->credentials($request);
			unset($check['password']);
			$user = config('auth.providers.users.model')::where($check)->first();
			if(!$user)
			{
				throw ValidationException::withMessages([
					$this->username() => [_d('auth.failed')],
				]);
			}
			dispatch(new \Majazeh\Dashboard\Jobs\SendEmail('emails.verify', ['email' => $username, 'token' => $token]));
            \Session::flash('registerMsg', _d('Check your email!'));
			return $this->showLoginForm();
		}
		if(!config('auth.enter.login', true))
		{
			throw ValidationException::withMessages([
					$this->username() => [_d('auth.login.disabled')],
				]);
		}
		return $this->auth_login($request);
	}

	/**
	 * @return username field in html form
	 */
	public function username()
	{
		return $this->username_method();
	}

	/**
	 * @return resources blade view for form login
	 */
	public function showLoginForm()
	{
		return $this->view('auth.login');
	}

	/**
	 * @param  Request request
	 * @return query where for find valid user if status not active user has not permision for login
	 */
	protected function credentials(Request $request)
	{
		return array_merge($request->only($this->username(), 'password'), ['status' => 'active']);
	}

	/**
	 * @return google login url
	 */
	public function redirectToProvider()
	{
		return \Socialite::driver('google')->redirect();
	}

	/**
	 * @return google login callback
	 */
	public function handleProviderCallback(Request $request)
	{
		try {
			$user = \Socialite::driver('google')->user();
		} catch (\Exception $e) {
			return redirect('/login');
		}
		$existingUser = User::where('email', $user->email)->first();
		if($existingUser){
			if($existingUser->google_id != $user->id)
			{
				$existingUser->google_id = $user->id;
				$existingUser->avatar = $user->avatar;
				$existingUser->save();
			}
			$this->guard()->setUser($existingUser);
			if($existingUser->status != 'active')
			{
				return $this->sendFailedLoginResponse($request);
			}
			$this->guard()->login($existingUser, true);
			return $this->sendLoginResponse($request);
		} else {
			$this->social_media_register($user);
		}
		return redirect()->to('/dashboard');
	}

	/**
	 * @param  Request request
	 * chack fail login, if user is not active or not valid make exeption and if user not found run register controller
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
        // check if user login with social media
		$user = false;
		if($this->guard()->user())
		{
			$user = $this->guard()->user();
		}
		else
		{
			$user = \App\User::where($this->username(), $request->{$this->username()})->first();
		}

        // if user exists
		if($user)
		{
			$check_password = Hash::check($request->password, $user->password);

			if($user->status != 'active' &&
				(($request->password && $check_password) || !$request->password)
			)
			{
				throw ValidationException::withMessages([
					$this->username() => [_d('auth.activefailed')],
				]);
			}
			throw ValidationException::withMessages([
				$this->username() => [_d('auth.failed')],
			]);
		}
		elseif(config('auth.enter.auto_register', true))
		{
			$register = new RegisterController();
			$register->username_method = $this->username_method;
			return $register->register($request);
		}
		else {
			throw ValidationException::withMessages([
				$this->username() => [trans('auth.failed')],
			]);
		}
	}

	public function emailVerify($token){
		$token = UserSocialNetwork::where('token', $token)->where('verify', 'waiting')->first();
		if($token)
		{
			$token->verify = 'verified';
			$token->save();
			$token->user->status = 'active';
			$token->user->save();
			return redirect()->to('/login');
		}
	}
}

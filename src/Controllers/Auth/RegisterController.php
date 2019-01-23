<?php

namespace Majazeh\Dashboard\Controllers\Auth;

use App\User;
use App\UserSocialNetwork;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class RegisterController extends AuthController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        if(!config('auth.enter.register', true))
		{
			throw ValidationException::withMessages([
					$this->username_method() => [_d('auth.register.disabled')],
				]);
		}
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
                        ?: redirect('/login');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validation = [
            'email'  => 'required|string|email|max:255|unique:users',
            'mobile' => 'required',
        ];
        $username = $this->username_method() == 'username' ? 'email' : $this->username_method();

        return Validator::make($data, [
            'password' => 'required|string|min:6',
            $username  => $validation[$username]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $username = request($this->username_method());

        $register = $this->user_create([
            'name' => 'anonymous',
            'password' => Hash::make($data['password']),
        ], [
            $this->username_method() => $username,
        ]);

        if($this->username_method() == 'email')
        {
            $token = md5(time() . $username . rand());
            UserSocialNetwork::create([
                'user_id'             => $register->id,
                'social_network'      => 'email',
                'social_network_user' => $username,
                'token'               => $token
            ]);
            \Session::flash('registerMsg', _d('Check your email!'));
            dispatch(new \Majazeh\Dashboard\Jobs\SendEmail('emails.verify', ['email' => $username, 'token' => $token, 'title' => _d('register.complate')]));
        }
        return $register;
    }
}

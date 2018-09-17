<?php
namespace Majazeh\Dashboard\Controllers\Auth;

use App\User;
use Majazeh\Dashboard\Controllers\Controller;

class AuthController extends Controller
{
    public $redirectTo = '/dashboard';

	public $username_method = null;
	public function username_method()
	{
		if($this->username_method) return $this->username_method;
		$username = request('username');
		$type = 'username';
		if(ctype_digit($username)){
			$type = 'mobile';
			request()->request->remove('username');
			request()->request->add([$type => $username]);
		}
		elseif(strpos($username, '@'))
		{
			$type = 'email';
			request()->request->remove('username');
			request()->request->add([$type => $username]);

		}
		$this->username_method = $type;
		return $type;
	}

	public function social_media_register($user)
	{
		$data 				= [];
		$data['name']		= $user->name;
		$data['email']		= $user->email;
		$data['google_id']	= $user->id;
		$data['avatar']		= $user->avatar;
		$newUser 			= $this->user_create($data, $data);
		auth()->login($newUser, true);
	}



	public function user_create($data, $_data = []){
		$new = User::create($data);
		// dd(User::count());
		if(User::count() === 1)
		{
			$_data['type'] = 'admin';
			$_data['name'] = 'Admin';
			$_data['status'] = 'active';
		}
		if(!empty($_data))
		{
			foreach ($_data as $key => $value) {
				$new->{$key} = $value;
			}
			$new->save();
		}
		return $new;
	}
}
?>
<?php

namespace Majazeh\Dashboard\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends AuthController
{

    use ResetsPasswords;

    public function showResetForm(Request $request, $token = null)
    {
        \Data::set('token', $token);
		return $this->view('auth.login');
    }

    public function iReset(Request $request, $token)
    {
        $request->request->add(['email' => $request->username, 'token' => $token, 'password_confirmation' => $request->password]);
        return $this->reset($request);
    }

    public function __construct(Request $request)
    {
        $this->middleware('guest');
		parent::__construct($request);
    }
}

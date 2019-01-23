<?php

namespace Majazeh\Dashboard\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends AuthController
{

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }
}

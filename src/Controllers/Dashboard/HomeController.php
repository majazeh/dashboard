<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Illuminate\Http\Request;
use Majazeh\Dashboard\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->view('dashboard.home');
    }
}

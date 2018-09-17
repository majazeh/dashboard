<?php

namespace Majazeh\Dashboard\Controllers\Dashboard;

use Illuminate\Http\Request;
use Majazeh\Dashboard\Controllers\Controller;

class HomeController extends Controller
{
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

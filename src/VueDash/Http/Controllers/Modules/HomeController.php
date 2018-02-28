<?php

namespace Palamike\VueDash\Http\Controllers\Modules;

use Palamike\VueDash\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vueDash::modules.home', [ 'menu' => 'dashboard' ]);
    }
}

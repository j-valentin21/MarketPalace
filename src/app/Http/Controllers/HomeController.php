<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        return view('home');
    }

    /**
     * Show default personal-token view from laravel passport.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTokens(): \Illuminate\Contracts\Support\Renderable
    {
        return view('home.personal-tokens');
    }
}

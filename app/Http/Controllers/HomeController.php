<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application register page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show the application login page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        return view('auth.login');
    }
}

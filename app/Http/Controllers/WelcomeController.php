<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:3,1');
    }

    public function index()
    {
        return view('welcome');
    }

    public function locale()
    {
        $cookie = cookie()->forever('local__myapp', request('locale'));

        cookie()->queue($cookie);

        return ($return = request('return'))
            ? redirect(urldecode($return))->withCookie($cookie)
            : redirect('/')->withCookie($cookie);

    }
}

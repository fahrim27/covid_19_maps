<?php

namespace App\Http\Controllers\Auth\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KlienController extends Controller
{
    protected $redirectTo = '/kliens/home';

    public function __construct()
    {
        $this->middleware('auth:klien')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function username()
    {
        return 'user_name';
    }
    protected function guard()
    {
        return Auth::guard('klien');
    }
}

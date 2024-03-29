<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ( in_array($user->role, [0,1,2]) ) {// do your margic here
            return redirect()->route('admin.index');
        }   
        else if(in_array($user->role, [4])){
            return redirect()->route('pasien.laporan.index');
        }
        else if(in_array($user->role, [5,6])){
            return redirect()->url('/dinas/dashboard');
        }
        else{
            return redirect()->route('posko.fitur.index');
        }
    }

    // /**
    //  * Where to redirect users after login.
    //  *
    //  * @var string
    //  */
    //protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

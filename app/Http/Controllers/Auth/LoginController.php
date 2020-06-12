<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function show(){
        return view('auth.login')->with(['error' => 'Informações de login incorretas...']);;
    }

    public function authenticate(Request $request){
        
        $email    = $request->email;
        $password = $request->password;

        if(\Auth::attempt(['email' => $email, 'password' => $password])){
            return redirect()->route('inicial');
        } else {
            \Auth::logout();
            return redirect('login')->with('error', 'Informações de login incorretas...');
        }

    }

    public function logout(){
        \Auth::logout();

        return redirect()->route('login');

    }

}

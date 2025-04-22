<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login/v2'); // Redirect to login page after logout
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password_hash' => 'required'
        ]);
    
        $user = \App\User::where('email', $request->email)->first();
        Log::info("The role is: ".$user->role);
    
        if ($user && Hash::check($request->password_hash, $user->password_hash)) {
            Auth::login($user);
          

            return redirect()->route('dashboard-v2')->with('success', 'Login successful!');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    
}

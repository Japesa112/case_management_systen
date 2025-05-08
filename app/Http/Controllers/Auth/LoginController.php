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
    
        if ($user) {
            $passwordMatches = Hash::check($request->password_hash, $user->password_hash);
            Log::info("Login attempt for: " . $user->email);
            Log::info("User Email: " . $user->email);
            Log::info("User Entered Password: " .  $request->password_hash);
            Log::info("User Registered Password: " . $user->password_hash);
            Log::info("User role: " . $user->role);
            Log::info("Password match result: " . ($passwordMatches ? 'true' : 'false'));
        } else {
            Log::warning("Login failed: User not found for email " . $request->email);
        }
    
        if ($user && Hash::check($request->password_hash, $user->password_hash)) {
            Auth::login($user);
            if($user->role === 'Lawyer') {
                return redirect()->route('dashboard-v2-lawyer')->with('success', 'Login successful!');
            } 
            return redirect()->route('dashboard-v2')->with('success', 'Login successful!');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    
    
}

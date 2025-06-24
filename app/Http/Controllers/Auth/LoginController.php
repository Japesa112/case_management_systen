<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\GoogleUser; // or App\Models\User if you're using the legacy structure
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        

        if (Auth::check()) {
            $user = Auth::user();
            $user->logged_out_at = now();
            $user->save();
        }

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
    
        $user = \App\Models\User::where('email', $request->email)->first();
    
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
            $user->logged_in_at = now();   // 👈 new
            $user->save();
            Auth::login($user);
            if($user->role === 'Lawyer') {
                return redirect()->route('dashboard-v2-lawyer')->with('success', 'Login successful!');
            } 
            return redirect()->route('dashboard-v2')->with('success', 'Login successful!');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }


public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();
    $email      = $googleUser->getEmail();

    // 1️⃣ Try to find an existing Laravel user
    $user = User::where('email', trim($email))->first();
    Log::info("Login attempt for: " . $email);

    //$user = User::where('email', $email)->first();

    if (!$user) {
        // 2️⃣ No match → bounce back with friendly message
        return redirect()
            ->route('login')                // or wherever your form lives
            ->withErrors([
                'google' => 'This email account isn’t registered. Please contact the administrator to be added to the system.'
            ]);
    }

    // 3️⃣ User exists → link Google ID if we haven’t before
    if (is_null($user->google_id)) {
        $user->google_id = $googleUser->getId();
    }

    // 4️⃣ Stamp login time
    $user->logged_in_at = now();
    $user->save();

    // 5️⃣ Standard Laravel login + redirect based on role
    Auth::login($user);

    return $user->role === 'Lawyer'
        ? redirect()->route('dashboard-v2-lawyer')
        : redirect()->route('dashboard-v2');
}




    
    
}

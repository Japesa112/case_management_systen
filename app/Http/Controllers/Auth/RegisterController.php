<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'first'    => 'required|string|max:255',
            'last'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email|confirmed',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:Lawyer,Admin,Case Manager,Evaluator,DVC,Other',
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)->numbers()->letters()->mixedCase()->symbols()
            ],
            'email_confirmation'    => 'required|email',
            'password_confirmation' => 'required'
        ]);
    
        try {
            // Create user
            $user = User::create([
                'username' => strtolower($validatedData['first'] . $validatedData['last']),
                'email'    => $validatedData['email'],
                'password_hash' => Hash::make($validatedData['password']), // Use password_hash instead of password
                'full_name' => $validatedData['first'] . " " . $validatedData['last'],
                'phone'    => $validatedData['phone'],
                'role'     => $validatedData['role'],
                'account_status' => 'Pending', // Default status
                'created_at' => now(),
                'last_login' => now(),
            ]);
    
            Auth::login($user); // Auto-login after registration
    
            return redirect()->route('dashboard-v2')->with('success', 'Registration successful!');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
    
}

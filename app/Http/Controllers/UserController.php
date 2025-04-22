<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Lawyer;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
   
     public function store(Request $request)
     {
        
        try{
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15|unique:users',
                'role' => 'required|string|in:user,lawyer',
                'license_number' => 'required_if:role,lawyer|string|max:255|unique:lawyers',
                'area_of_expertise' => 'nullable|string|max:255',
                'firm_name' => 'nullable|string|max:255',
                'years_experience' => 'nullable|integer|min:0',
                'working_hours'=> 'nullable|string|max:255',
            ]);
        
            // Generate username
            $lastThreeDigits = substr($request->phone, -3);
            $username = strtolower(str_replace(' ', '', $request->full_name)) . $lastThreeDigits;
        
            // Set password as phone number (hashed)
            $password_hash = Hash::make($request->phone);
        
            // Create the User
            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'username' => $username,
                'password_hash' => $password_hash,
                'role' => $request->role,
            ]);
        
            // If the user is a lawyer, create a Lawyer record
            if ($request->role === 'lawyer') {
                Lawyer::create([
                    'user_id' => $user->user_id,
                    'license_number' => $request->license_number,
                    'area_of_expertise' => $request->area_of_expertise,
                    'firm_name' => $request->firm_name,
                    'years_experience' => $request->years_experience,
                    'working_hours'=> $request->working_hours,
                ]);
   
                return redirect()->route('lawyers.index')->with('success', 'Lawyer created successfully.');
   
   
            }
        } catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        
        
     
     }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}


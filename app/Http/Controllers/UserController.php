<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Lawyer;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer','block-lawyer-from-users'])->except(['showLoginForm']); // Applies to all methods in the controller

        
}     
   public function index()
{
    $users = User::orderBy('created_at', 'desc')->paginate(10);
    return view('users.index', compact('users'));
}


    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }
    public function change_password()
    {
        return view('users.change');
    }

    public function help()
    {
        return view('users.help');
    }



    /**
     * Store a newly created user in storage.
     */
   
     public function store(Request $request)
     {
        
        try{

            $request->merge([
                'email' => trim($request->email),
                'phone' => trim($request->phone),
                'full_name' => trim($request->full_name),
            ]);

            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15|unique:users',
                'role' => 'required|string|in:user,lawyer,Admin',
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
            else{
                return redirect()->route('users.index')->with('success', 'User created successfully.');
            }
        } catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        
        
     
     }
     public function showLoginForm(){
        return view('pages.login-v2');
     }
     public function show($user_id)
     {
         try{
            $user = User::where('user_id', $user_id)->firstOrFail();
     
         return response()->json([
             'full_name'       => $user->full_name,
             'username'        => $user->username,
             'email'           => $user->email,
             'phone'           => $user->phone,
             'role'           => $user->role,
             
         ]);
         }
         catch(Exception $e){    
             Log::error(''. $e->getMessage());
             return response()->json([$e->getMessage()],500);
         }
         
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

     public function update(Request $request, $user_id)
     {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string|max:15',
        ]);
    
        $user = User::where('user_id', $user_id)->firstOrFail();
    
        $user->update($data);
    
         return response()->json(['redirect' => route('users.index'), 'message' => 'User details updated successfully!']);
         
     
      
         
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


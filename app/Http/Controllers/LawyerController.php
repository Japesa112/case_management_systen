<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer; // Assuming you have a Lawyer model
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Hash;
use App\Models\CaseLawyer;
use App\Models\CaseClosure;
use App\Models\PanelEvaluation;
use App\Models\DvcAppointment;

class LawyerController extends Controller
{
    /**
     * Show the list of lawyers.
     */

     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

public function getCasesAwaitingEvaluationStats()
{
    try {
        $count = 0;
        $change = 0;
        $trend = 'Stable';

        if (Auth::check() && Auth::user()->role === 'Lawyer') {
            $lawyerId = Auth::user()->lawyer->lawyer_id;

            

            // Filter cases that are not closed
            $openCases = CaseModel::where('case_status', '!=', 'Closed')
                ->pluck('case_id');

            // Get cases the lawyer has already evaluated
            $evaluatedCaseIds = PanelEvaluation::where('lawyer_id', $lawyerId)->pluck('case_id');

            // Subtract to find cases awaiting evaluation
            $awaitingCases = $openCases->diff($evaluatedCaseIds);

            $count = $awaitingCases->count();
        }

        return response()->json([
            'count' => $count,
            'change' => $change, // Optional: you can calculate trend later
            'trend' => $trend
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching cases awaiting evaluation: " . $e->getMessage());
        return response()->json([
            'error' => 'Failed to fetch data'
        ], 500);
    }
}

public function getCasesAwaitingAction()
{
    try {
        $isLawyer = Auth::check() && Auth::user()->role === 'Lawyer';

        if ($isLawyer) {
            $lawyerId = Auth::user()->lawyer->lawyer_id;

            // Get evaluated case IDs
            $evaluatedCaseIds = PanelEvaluation::where('lawyer_id', $lawyerId)->pluck('case_id');

            // Count cases assigned to lawyer that are not closed and not yet evaluated
            $awaitingCount = CaseModel::whereNotIn('case_id', $evaluatedCaseIds)
                ->where('case_status', '!=', 'Closed')
                ->count();

            return response()->json(['count' => $awaitingCount]);
        }

        return response()->json(['count' => 0]);
    } catch (\Exception $e) {
        \Log::error("Error fetching awaiting cases: " . $e->getMessage());
        return response()->json(['count' => 0], 500);
    }
}
    public function getComplianceStats()
{
    try {
        $user = Auth::user();

        if ($user && $user->role === 'Lawyer') {
            $lawyer = $user->lawyer;

            $defaultPassword = $lawyer->phone;

            $isUsingDefaultPassword = Hash::check($defaultPassword, $user->password);

            $complianceIssues = [];

            if ($isUsingDefaultPassword) {
                $complianceIssues[] = 'Password has not been updated from default.';
            }

            return response()->json([
                'issues' => $complianceIssues,
                'compliant' => empty($complianceIssues)
            ]);
        }

        return response()->json(['error' => 'Unauthorized or not a lawyer.'], 403);
    } catch (\Exception $e) {
        Log::error('Error checking compliance: ' . $e->getMessage());

        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

    public function index()
    {
        $lawyers = Lawyer::orderBy('created_at', 'desc')->paginate(10);

        return view('lawyers.index', compact('lawyers'));

    }

    public function dashboard()
    {
        $wonCases = 0;
        $lostCases = 0;
        $closedCases = 0;
    
        if (Auth::check() && Auth::user()->role === 'Lawyer') {
            $lawyerId = Auth::user()->lawyer->lawyer_id;
    
            // Get case IDs assigned to this lawyer
            $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');
    
            // Count wins and losses for those cases only
            $wonCases = CaseClosure::whereIn('case_id', $caseIds)
                            ->where('final_outcome', 'Win')
                            ->count();
    
            $lostCases = CaseClosure::whereIn('case_id', $caseIds)
                            ->where('final_outcome', 'Loss')
                            ->count();
    
            $closedCases = $wonCases + $lostCases;
        }
    
        return view('lawyers.dashboard', [
            'wonCases' => $wonCases,
            'lostCases' => $lostCases,
            'closedCases' => $closedCases,
        ]);
    }


    public function delete(){
        $lawyers = Lawyer::paginate(10); // Instead of get(), use paginate()
        return view('lawyers.remove', compact('lawyers')); // Direct to lawyers listing page
  
    }
    public function edit_(){
        $lawyers = Lawyer::paginate(10); // Instead of get(), use paginate()
        return view('lawyers.edit_', compact('lawyers')); // Direct to lawyers listing page
  
    }
    /**
     * Show the form for adding a new lawyer.
     */
    public function create()
    {
        return view('lawyers.create'); // Direct to add lawyer form
    }

    /**
     * Store a new lawyer in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lawyers',
            'phone' => 'required|string|max:15',
            'specialization'=> 'required',
            'bar_number' => 'required|string',
            'experience_years' => 'required|numeric',
        ]);

        $createdLawyer = Lawyer::create($request->all());

        return redirect()->route('lawyers.index')
        ->with('success', 'Lawyer added successfully!')
        ->with('createdLawyer',$createdLawyer);
    }

    /**
     * Show the form to edit a lawyer’s details.
     */
    public function edit(Lawyer $lawyer)
    {
        
        return view('lawyers.edit', ['lawyer'=> $lawyer]);
    }

    /**
     * Update a lawyer’s details.
     */
    public function update(Request $request, $lawyer_id)
{
    $data = $request->validate([
        'full_name'       => 'required|string|max:255',
        'username'        => 'required|string|max:255',
        'email'           => 'required|email',
        'phone'           => 'required|string|max:15',
        'license_number'  => 'required|string',
        'area_of_expertise' => 'required|string|max:255',
        'firm_name'       => 'required|string|max:255',
        'years_experience' => 'required|numeric',
        'working_hours'   => 'required|string|max:255',
    ]);

    // Find the lawyer and load related user
    $lawyer = Lawyer::with('user')->where('lawyer_id', $lawyer_id)->firstOrFail();

    // Update lawyer-specific fields
    $lawyer->update([
        'license_number'  => $data['license_number'],
        'area_of_expertise' => $data['area_of_expertise'],
        'firm_name'       => $data['firm_name'],
        'years_experience' => $data['years_experience'],
        'working_hours'   => $data['working_hours'],
    ]);

    // Update related user fields
    $lawyer->user->update([
        'full_name' => $data['full_name'],
        'username'  => $data['username'],
        'email'     => $data['email'],
        'phone'     => $data['phone'],
    ]);

    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer';

    if ($isLawyer) {
        return response()->json(['redirect' => url('/dashboard/lawyer'), 'message' => 'Your details updated successfully!']);
    } else {
        return response()->json(['redirect' => route('lawyers.index'), 'message' => 'Lawyer details updated successfully!']);
    }

 
    
}

    public function show($lawyer_id)
{
    try{
        $lawyer = Lawyer::with('user')->where('lawyer_id', $lawyer_id)->firstOrFail();

    return response()->json([
        'full_name'       => $lawyer->user->full_name,
        'username'        => $lawyer->user->username,
        'email'           => $lawyer->user->email,
        'phone'           => $lawyer->user->phone,
        'license_number'  => $lawyer->license_number,
        'area_of_expertise' => $lawyer->area_of_expertise,
        'firm_name'       => $lawyer->firm_name,
        'years_experience' => $lawyer->years_experience,
        'working_hours'   => $lawyer->working_hours,
    ]);
    }
    catch(Exception $e){    
        Log::error(''. $e->getMessage());
        return response()->json([$e->getMessage()],500);
    }
    
}

    /**
     * Remove a lawyer from the database.
     */
    public function destroy($id)
    {
        $lawyer = Lawyer::findOrFail($id);
        $lawyer->delete();

        return redirect()->route('lawyers.index')->with('success', 'Lawyer removed successfully!')
        ->with('deletedLawyer', $lawyer);
        
    }


    public function my_index()
{
              $lawyerId = Auth::user()->user_id;

            // Step 1: Get evaluation_ids from PanelEvaluation for this lawyer
            $lawyerEvaluationIds = PanelEvaluation::where('lawyer_id', $lawyerId)
                ->pluck('evaluation_id');

            // Step 2: Find which of those evaluations are in the DvcAppointment table
            $forwardedEvaluationIds = DvcAppointment::whereIn('evaluation_id', $lawyerEvaluationIds)
                ->pluck('evaluation_id');

            // Step 3: Get the case_ids for those forwarded evaluations
            $caseIds = PanelEvaluation::whereIn('evaluation_id', $forwardedEvaluationIds)
                ->pluck('case_id');

            // Step 4: Return cases
            $cases = CaseModel::whereIn('case_id', $caseIds)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('lawyers.my_index', compact('cases'));
    }


public function changePassword(Request $request)
{

     /** @var \App\User $user */
    $user = Auth::user();

    // Validate input
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed', // matches new_password_confirmation
    ]);

    // Check current password
    if (!Hash::check($request->current_password, $user->password_hash)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Current password is incorrect.'
        ], 422);
    }

    // Everything's good, update password
    $user->password_hash = Hash::make($request->new_password);
    $user->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Password updated successfully.'
    ]);
}


}

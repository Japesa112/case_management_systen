<?php

namespace App\Http\Controllers;

use App\Models\PanelEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use  Illuminate\Support\Facades\Auth;
use App\Models\CaseModel;
use App\User;
class PanelEvaluationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function index()
{
    $user = Auth::user();
    $isLawyer = $user && $user->role === 'Lawyer';

    if ($isLawyer) {
        // Get the lawyer_id from the authenticated user
        $lawyerId = $user->lawyer ? $user->lawyer->lawyer_id : null;

        if ($lawyerId) {
            // Fetch evaluations for the logged-in lawyer
            $evaluations = PanelEvaluation::with(['case', 'user'])
                ->where('lawyer_id', $lawyerId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Handle case where lawyer relationship doesn't exist
            $evaluations = collect(); // empty collection
        }
    } else {
        // Fetch all evaluations for non-lawyer users
        $evaluations = PanelEvaluation::with(['case', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return view('evaluations.index', compact('evaluations'));
}



    public function create(Request $request) 
{
    $case_id = $request->case_id ?? null;
    $case_name = null;
    $evaluation = null;



    if ($case_id) {
        // Retrieve the case record based on the provided case_id
        $caseRecord = \App\Models\CaseModel::find($case_id);
        if ($caseRecord) {
            $case_name = $caseRecord->case_name;
            $evaluation = $caseRecord->evaluations()->latest()->first();
        }
    }
    $evaluation =PanelEvaluation::where('case_id', $case_id)->latest()->first();

    // Debugging output
    return view('evaluations.create', compact('case_id', 'case_name', 'evaluation'));
    /*

    if ($evaluation) {
        return view('evaluations.edit', [
            'evaluation' => $evaluation,
            'case_id' => $evaluation->case_id,
            'case_name' => $case_name
        ]);
    }
        return view('evaluations.create', compact('case_id', 'case_name', 'evaluation'));

    
*/
    }



public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'case_id'          => 'required|exists:cases,case_id', // Ensure the case exists
        'lawyer_id'        => 'required|exists:users,user_id', // Ensure the lawyer exists
        'evaluation_date'  =>  'required|date_format:Y-m-d\TH:i',
        'comments'         => 'nullable|string',
        'pager'            =>  'nullable|string',
        'quote'            => 'nullable|numeric',
        'worked_before'    => 'required|in:Yes,No',
    ]);
    $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->evaluation_date);
    $evaluation_date = $dateTime->toDateString();
    $evaluation_time = $dateTime->toTimeString();
    try {
        // Store the evaluation
        $evaluation = PanelEvaluation::create([
            'case_id'         => $request->case_id,
            'lawyer_id'       => $request->lawyer_id,
            'evaluation_date' => $evaluation_date,
            'evaluation_time' => $evaluation_time,
            'comments'        => $request->comments,
            'quote'           => $request->quote,
            'pager'           => $request->pager,
            'worked_before'   => $request->worked_before,
            'outcome'         => $request->outcome,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        $case = CaseModel::find($request->case_id);
        if ($case) {
          
 // Assuming you want to set the case status to "Scheduled" when a hearing is added
            $case->case_status = "Under Panel Evaluation"; // Change this as needed
            $case->save();
        } 


        return redirect()->route('evaluations.index')->with('success', 'Evaluation created successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create evaluation. ' . $e->getMessage());
    }
}


public function show(PanelEvaluation $evaluation)
{

    $formattedDateTime = $evaluation->evaluation_date && $evaluation->evaluation_time
    ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$evaluation->evaluation_date $evaluation->evaluation_time")->format('Y-m-d\TH:i')
    : '';
    if (request()->ajax()) {
        return response()->json([
            'evaluation' => [
                'case_name' => $evaluation->case->case_name ?? 'N/A',
                'lawyer_name' => $evaluation->user->full_name ?? 'N/A',
                'evaluation_date' => $evaluation->evaluation_date,
                'evaluation_time' => $evaluation->evaluation_time,
                'quote' => $evaluation->quote,
                'outcome' => $evaluation->outcome,
                'pager' => $evaluation->pager,
                'worked_before' => $evaluation->worked_before,
                'comments' => $evaluation->comments,
                'formattedDateTime'=> $formattedDateTime,
            ]
        ]);
    }

    return view('evaluations.show', compact('evaluation'));
}

    public function edit(PanelEvaluation $evaluation)
    {
        
    $formattedDateTime = $evaluation->evaluation_date && $evaluation->evaluation_time
    ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$evaluation->evaluation_date $evaluation->evaluation_time")->format('Y-m-d\TH:i')
    : '';
    $evaluation['formattedDateTime'] = $formattedDateTime;
        return view('evaluations.edit', compact('evaluation'));
    }

    public function update(Request $request, PanelEvaluation $evaluation)
{
    $request->validate([
        'evaluation_date' => 'required|date_format:Y-m-d\TH:i',
        'worked_before' => 'required|in:Yes,No',
        'outcome' => 'required|in:Yes,No',
        'quote' => 'nullable|string|max:255',
        'pager' => 'nullable|string|max:255',
        'comments' => 'nullable|string|max:1000',
    ]);
    $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->evaluation_date);
    $evaluation_date = $dateTime->toDateString();
    $evaluation_time = $dateTime->toTimeString();
    $evaluation->update([
        'evaluation_date' => $evaluation_date,
        'evaluation_time' => $evaluation_time,
        'worked_before' => $request->worked_before,
        'outcome' => $request->outcome,
        'quote' => $request->quote,
        'pager' => $request->pager,
        'comments' => $request->comments,
    ]);

    return redirect()->route('evaluations.index')->with('success', 'Evaluation updated successfully.');
}

    public function destroy(PanelEvaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'Evaluation deleted!');
    }


    public function checkCase(Request $request)
{
    try {
        $case_number = trim($request->case_number); // Trim spaces

        // Find the case in the database
        $case = \App\Models\CaseModel::whereRaw('LOWER(case_number) = ?', [strtolower($case_number)])->first();

        if (!$case) {
            // Case not found - return JSON response for AJAX
            return response()->json([
                'exists' => false,
                'message' => 'Case not found'
            ], 404);
        }
        $latestNegotiation = $case->negotiations()->latest()->first(); // Fetch latest negotiation

        if ($latestNegotiation) {
            return response()->json([
                'exists' => true,
                'case_id' => $case->case_id,
                'case_name' => $case->case_name,
                'negotiation' => [
                    'id' => $latestNegotiation->id,
                    'edit_url' => route('negotiations.edit', $latestNegotiation) // Generate edit URL
                ]
            ]);
        }

        // Case found - return JSON response instead of redirect
        return response()->json([
            'exists' => true,
            'case_id' => $case->case_id,
            'case_name' => $case->case_name,
            'negotiation' => null
        ]);
    } catch (\Exception $e) { 
        return response()->json([
            'error' => true,
            'message' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}



public function checkEvaluation(Request $request, $case_id)
{
    $lawyer_id = $request->lawyer_id;

    // Check if an evaluation exists for this case and lawyer
    $evaluation = PanelEvaluation::where('case_id', $case_id)
                    ->where('lawyer_id', $lawyer_id)
                    ->first();
    Log::info("The evaluation id is: ".$evaluation->evaluation_id);
    if ($evaluation) {
        return response()->json([
            'exists' => true,
            'evaluation' => $evaluation // Send evaluation ID for editing
        ]);
    } else {
        return response()->json(['exists' => false]);
    }
}

}
<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CaseModel;
class NegotiationController extends Controller
{
    /**
     * Display a listing of negotiations.
     */

     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function index()
    {
        $negotiations = Negotiation::with(['attachments', 'caseRecord'])->orderBy('created_at', 'desc')->get();

        return view('negotiations.index', compact('negotiations'));
    }
    

    public function create(Request $request)
{
    $case_id = $request->case_id ?? null;
    $case_name = null;
    $negotiation = null;
    if ($case_id) {
        // Retrieve the case record based on the provided case_id
        $caseRecord = \App\Models\CaseModel::find($case_id);
        if ($caseRecord) {
            $case_name = $caseRecord->case_name;
            $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();

        }
    }

    if($negotiation){
        return view('negotiations.edit', [
            'negotiation' => $negotiation,
            'case_id' => $negotiation->case_id,
            'attachments' => $negotiation->attachments,
            'case_name' => $case_name
        ]);
    }

    // This could be null if not provided
    
    return view('negotiations.create', compact('case_id', 'case_name', 'negotiation'));
}
    /**
     * Store a newly created negotiation in storage.
     */
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'case_id'                => 'required|exists:cases,case_id',
            'negotiator_id'          => 'required|exists:users,user_id',
            'negotiation_method'     => 'required|string|max:100',
            'subject'                => 'nullable|string|max:255',
            'initiation_datetime'    => 'required|date',
            'follow_up_date'         => 'nullable|date',
            'follow_up_actions'      => 'nullable|string',
            'final_resolution_date'  => 'nullable|date',
            'additional_comments'    => 'nullable|string',
            'notes'                  => 'nullable|string',
            'outcome'                => 'nullable|in:Resolved,Pending,Requires Further Action,Closed,Declined',
            'complainant_response'   => 'nullable|string',
        ]);

        
         // Check if a negotiation already exists for the given case_id
         $existingNegotiation = Negotiation::where('case_id', $request->case_id)->first();

         if ($existingNegotiation) {
             return redirect()->back()
                 ->withErrors(['error' => 'A negotiation already exists for this case. Please update it instead.'])
                 ->with('existingNegotiation', $existingNegotiation->negotiation_id);
         }

        // Create a new negotiation if none exists
        $negotiation = Negotiation::create($validatedData);
        $case = CaseModel::find($request->case_id);
        if ($case) {
          
 // Assuming you want to set the case status to "Scheduled" when a hearing is added
            $case->case_status = "Under Negotiation"; // Change this as needed
            $case->save();
        } 

        return redirect()->route('negotiations.create', ['case_id' => $validatedData['case_id'], 'negotiation' => $negotiation])
                         ->with('negotiation_success', true);

    } catch (\Exception $e) {
        Log::error('Negotiation not created: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Something went wrong. Please try again.']);
    }
}

    

    /**
     * Display the specified negotiation.
     */
    public function show($id) 
    {
        $negotiation = Negotiation::find($id);
        
        if (!$negotiation) {
            return redirect()->route('negotiations.index')->withErrors(['error' => 'Negotiation not found.']);
        }
    
        $case = \App\Models\CaseModel::find($negotiation->case_id);
        
        return view('negotiations.view', [
            'negotiation' => $negotiation,
            'case_id' => $negotiation->case_id,
            'attachments' => $negotiation->attachments,
            'case_name' => $case ? $case->case_name : null
        ]);
    }

    /**
     * Update the specified negotiation in storage.
     */
    public function update(Request $request, $id)
{
    try {
        $negotiation = Negotiation::findOrFail($id);

        $validatedData = $request->validate([
            'case_id'                => 'sometimes|required|exists:cases,case_id',
            'negotiator_id'          => 'sometimes|required|exists:users,user_id',
            'negotiation_method'     => 'sometimes|required|string|max:100',
            'subject'                => 'nullable|string|max:255',
            'initiation_datetime'    => 'sometimes|required|date',
            'follow_up_date'         => 'nullable|date',
            'follow_up_actions'      => 'nullable|string',
            'final_resolution_date'  => 'nullable|date',
            'additional_comments'    => 'nullable|string',
            'notes'                  => 'nullable|string',
            'outcome'                => 'nullable|in:Resolved,Pending,Requires Further Action,Closed,Declined',
            'complainant_response'   => 'nullable|string',
        ]);

        $negotiation->update($validatedData);

        return response()->json([
            'message'     => 'Negotiation updated successfully',
            'negotiation' => $negotiation,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error updating negotiation: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Remove the specified negotiation from storage.
     */
    public function destroy($id)
    {
        $negotiation = Negotiation::findOrFail($id);
        $negotiation->delete();

        return response()->json([
            'message' => 'Negotiation deleted successfully'
        ]);
    }

    public function edit($id) 
{
    $negotiation = Negotiation::find($id);
    
    if (!$negotiation) {
        return redirect()->route('negotiations.index')->withErrors(['error' => 'Negotiation not found.']);
    }

    $case = \App\Models\CaseModel::find($negotiation->case_id);
    
    return view('negotiations.edit', [
        'negotiation' => $negotiation,
        'case_id' => $negotiation->case_id,
        'attachments' => $negotiation->attachments,
        'case_name' => $case ? $case->case_name : null
    ]);
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


}

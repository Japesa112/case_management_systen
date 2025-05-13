<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forwarding;
use \App\Models\CaseModel;
use Illuminate\Support\Facades\Log;

class ForwardingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function index()
    {
        $forwardings = Forwarding::with(['case', 'lawyer'])->get();
        
        return view('dvc_appointments.index', compact('forwardings'));
    }
    public function create($case_id, $evaluation_id)
    {
        $case_name = null;
        $case_number = null;
        $forwarding = null;
    
        // Retrieve the case record
        $caseRecord = \App\Models\CaseModel::find($case_id);
        if ($caseRecord) {
            $case_name = $caseRecord->case_name;
            $case_number = $caseRecord->case_number;
        }
    
        // Retrieve the evaluation if needed
        $evaluation = \App\Models\PanelEvaluation::find($evaluation_id);
        if ($evaluation) {
            $forwarding = $evaluation;
        }
    
        return view('dvc_appointments.create', compact('case_id', 'case_name', 'case_number', 'forwarding', 'evaluation_id'));
    }
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'evaluation_id' =>'required|exists:evaluations,evaluation_id',
            'case_id' => 'required|exists:cases,case_id',
            'dvc_appointment_date' =>  'required|date_format:Y-m-d\TH:i',
            'briefing_notes' => 'nullable|string',
        ]);

        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->dvc_appointment_date);
        $validated['dvc_appointment_date'] = $dateTime->toDateString();
        $validated['dvc_appointment_time'] = $dateTime->toTimeString();

        $case = CaseModel::with('lawyers1')->where('case_id', $validated['case_id'])->first();

        if ($case && $case->lawyers1->isNotEmpty()) {
            foreach ($case->lawyers1 as $lawyer) {
                Forwarding::create([
                    'evaluation_id'=> $validated['evaluation_id'],
                    'case_id' => $validated['case_id'],
                    'dvc_appointment_date' => $validated['dvc_appointment_date'],
                    'dvc_appointment_time' => $validated['dvc_appointment_time'],
                    'briefing_notes' => $validated['briefing_notes'] ?? null,
                ]);
            }
        } else {
            Forwarding::create([
                'evaluation_id'=> $validated['evaluation_id'],
                'case_id' => $validated['case_id'],
                'dvc_appointment_date' => $validated['dvc_appointment_date'],
                'dvc_appointment_time' => $validated['dvc_appointment_time'],
                'briefing_notes' => $validated['briefing_notes'] ?? null,
            ]);
        }

        $case = CaseModel::find(  $validated['case_id']);
        if ($case) {
          
 // Assuming you want to set the case status to "Scheduled" when a hearing is added
            $case->case_status = "Forwarded to DVC/VC"; // Change this as needed
            $case->save();
        } 

        return redirect()->route('dvc_appointments.index', [
            'case_id' => $request->case_id,
        ])->with('forwarding_success', true)
          ->with('success', 'The Advice Added successfully');

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show($forwarding_id)
{
    $forwarding = Forwarding::with('case')->find($forwarding_id);

    if (!$forwarding) {
        return response()->json([
            'error' => 'Forwarding record not found.'
        ], 404);
    }

    return response()->json([
        'forwarding' => $forwarding,
        'case_name' => $forwarding->case->case_name ?? 'Unknown Case',
         'case_number' => $forwarding->case->case_number ?? 'Unknown Case'
    ]);
}

public function update(Request $request, $forwarding_id)
{
    try {
        $validated = $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'dvc_appointment_date' => 'required|date_format:Y-m-d\TH:i',
            'briefing_notes' => 'nullable|string',
        ]);

        // Convert datetime-local to separate date and time
        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->dvc_appointment_date);
        $validated['dvc_appointment_date'] = $dateTime->toDateString();
        $validated['dvc_appointment_time'] = $dateTime->toTimeString();

        // Fetch the forwarding record
        $forwarding = Forwarding::where('forwarding_id', $forwarding_id)->first();

        if (!$forwarding) {
            return redirect()->back()->with('error', 'Forwarding record not found.');
        }

        // Update fields
        $forwarding->update([
            'case_id' => $validated['case_id'],
            'dvc_appointment_date' => $validated['dvc_appointment_date'],
            'dvc_appointment_time' => $validated['dvc_appointment_time'],
            'briefing_notes' => $validated['briefing_notes'],
        ]);
        return response()->json(['message' => 'Forwarding updated successfully!', 'forwarding' => $forwarding]);

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json(['error' => 'Error updating the forwarding!']);
    }
}

    /**
     * Update the specified resource in storage.
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'lawyer_id' => 'required|exists:lawyers,id',
            'dvc_appointment_date' => 'required|date',
            'briefing_notes' => 'nullable|string',
        ]);

        $forwarding = Forwarding::findOrFail($id);
        $forwarding->update($validated);

        return response()->json(['message' => 'Forwarding updated successfully!', 'forwarding' => $forwarding]);
    }
 */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $forwarding = Forwarding::findOrFail($id);
        $forwarding->delete();

        return response()->json(['message' => 'Forwarding deleted successfully!']);
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
            /*

            $latestAdjourn= $case->adjourns()->latest()->first(); // Fetch latest negotiation
    
            if ($latestAdjourn) {
                return response()->json([
                    'exists' => true,
                    'case_id' => $case->case_id,
                    'case_name' => $case->case_name,
                    'negotiation' => [
                        'id' => $latestAdjourn->adjourn_id,
                        'edit_url' => route('negotiations.edit', $latestAdjourn) // Generate edit URL
                    ]
                ]);
            }
                */
    
            // Case found - return JSON response instead of redirect
            return response()->json([
                'exists' => true,
                'case_id' => $case->case_id,
                'case_name' => $case->case_name,
                'advice' => null
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }


        
    }
}

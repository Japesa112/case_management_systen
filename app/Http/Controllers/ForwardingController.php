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
    public function index()
    {
        $forwardings = Forwarding::with(['case', 'lawyer'])->get();
        
        return view('forwarding.index', compact('forwardings'));
    }
    public function create($case_id) {
        $case_name = null;
        $case_number = null;
        $forwarding = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
                $case_number = $caseRecord->case_number;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('forwarding.create', compact('case_id', 'case_name', 'case_number', 'forwarding'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'dvc_appointment_date' => 'required|date',
                'briefing_notes' => 'nullable|string',
            ]);
            $case = CaseModel::where('case_id', $validated['case_id'])->with('lawyers')->first();
            if ($case && $case->lawyers()->isNotEmpty()) {
                // If evaluations exist, store the first evaluation's ID
                $validated['lawyer_id'] = $case->lawyers->first()->lawyer_id;
            } else {
                // If no evaluations exist, set evaluation_id as null
                $validated['lawyer_id'] = null;
            }
    
            $forwarding = Forwarding::create($validated);
            return redirect()->route('forwarding.index', [
                'case_id' => $request->case_id, 
                'forwarding' => $forwarding->forwarding_id
            ])->with('forwarding_success', true)
            ->with('success', 'The Advice Added successfully');
            ;
            
        
        }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $forwarding = Forwarding::with(['case', 'lawyer'])->findOrFail($id);
        return response()->json($forwarding);
    }

    /**
     * Update the specified resource in storage.
     */
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

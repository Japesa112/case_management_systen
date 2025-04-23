<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AGAdvice;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Log;
class AGAdviceController extends Controller
{
    /**
     * Display a listing of AG Advices.
     */
    public function index()
    {
        $advices = AGAdvice::with('case', 'evaluation')->orderBy('created_at', 'asc')->get();
        
        return view('ag_advice.index', compact('advices'));
    }

    /**
     * Show the form for creating a new AG Advice.
     */
    

    public function create($case_id) {
        $case_name = null;
        $case_number = null;
        $advice = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
                $case_number = $caseRecord->case_number;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('ag_advice.create', compact('case_id', 'case_name', 'case_number', 'advice'));
    }
    


    /**
     * Store a newly created AG Advice in the database.
     */
    public function store(Request $request)
    {
        try{

            $validated = $request->validate([
                'advice_date' => 'required|date_format:Y-m-d\TH:i',
                'ag_advice' => 'required|string',
                'case_id' => 'required|exists:cases,case_id',
            ]);
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->advice_date);
            $validated['advice_date']  = $dateTime->toDateString();
            $validated['advice_time'] = $dateTime->toTimeString();
            // Retrieve the case and check for evaluations
            $case = CaseModel::where('case_id', $validated['case_id'])->with('evaluations')->first();
        
            if ($case && $case->evaluations->isNotEmpty()) {
                // If evaluations exist, store the first evaluation's ID
                $validated['evaluation_id'] = $case->evaluations->first()->evaluation_id;
            } else {
                // If no evaluations exist, set evaluation_id as null
                $validated['evaluation_id'] = null;
            }
        
            $advice = AGAdvice::create($validated);
        
            return redirect()->route('ag_advice.index', [
                'case_id' => $request->case_id, 
                'advice' => $advice->ag_advice_id
            ])->with('advice_success', true)
            ->with('success', 'The Advice Added successfully');
            ;
        }

        catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
        
         }
    

    /**
     * Display the specified AG Advice.
     */
    

    public function show($ag_advice_id)
    {
        try{
            $advice = AGAdvice::with('case')->findOrFail($ag_advice_id);
            Log::info('The ID is: '. $advice->ag_advice_id .'   Data is: '.$advice);
            $formattedDateTime = $advice->advice_date && $advice->advice_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$advice->advice_date $advice->advice_time")->format('Y-m-d\TH:i')
            : '';
        return response()->json([
            'case_name' => $advice->case->case_name,
            'formattedDateTime'=> $formattedDateTime,
            'advice' => $advice,
            
        ]);
        }
        catch (\Exception $e) {
            Log::info("The function is not working");
            Log::error($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified AG Advice.
     */
    public function edit($id)
    {
        $advice = AGAdvice::findOrFail($id);
        return view('ag_advices.edit', compact('advice'));
    }

    /**
     * Update the specified AG Advice in the database.
     */
    public function update(Request $request, $id)
    {
        
        try{
            $validated = $request->validate([
                'advice_date' => 'required|date_format:Y-m-d\TH:i',
                'ag_advice' => 'required|string',
                'case_id' => 'required|exists:cases,case_id',
            ]);
        
            // Retrieve the case and check for evaluations
            $case = CaseModel::where('case_id', $validated['case_id'])->with('evaluations')->first();
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->advice_date);
            $validated['advice_date']  = $dateTime->toDateString();
            $validated['advice_time'] = $dateTime->toTimeString();
            if ($case && $case->evaluations->isNotEmpty()) {
                // If evaluations exist, store the first evaluation's ID
                $validated['evaluation_id'] = $case->evaluations->first()->id;
            } else {
                // If no evaluations exist, set evaluation_id as null
                $validated['evaluation_id'] = null;
            }
        
            // Find and update the AG Advice
            $advice = AGAdvice::findOrFail($id);
            $advice->update($validated);
        
            return response()->json(['message' => 'AG Advice updated successfully!', 'advice' => $advice]);
        }
        catch (\Exception $e) {
            Log::error("The update is not working");
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to Update Advice ' . $e->getMessage()], 500);
        }  
    }
    
    /**
     * Remove the specified AG Advice from the database.
     */
    public function destroy($id)
    {
        $advice = AGAdvice::findOrFail($id);
        $advice->delete();

        return response()->json(['message' => 'AG Advice deleted successfully!']);
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

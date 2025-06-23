<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;
use Illuminate\Support\Facades\Storage;
use App\Models\TrialAttachment;
use Illuminate\Support\Facades\Log;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseLawyer;

class TrialController extends Controller
{
    /**
     * Display a listing of the trials.
     */

     public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
    }

    public function index()
{
    $user = Auth::user();

    if ($user && $user->role === 'Lawyer') {
        $lawyerId = $user->lawyer->lawyer_id ?? null;

        // Get all case_ids assigned to this lawyer
        $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');

        // Get only trials related to the lawyer's cases
        $trials = Trial::with('case')
            ->whereIn('case_id', $caseIds)
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        // For non-lawyers, return all trials
        $trials = Trial::with('case')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return view('trials.index', compact('trials'));
}

    /**
     * Show the form for creating a new trial.
     */
    public function create($case_id) {
        $case_name = null;
        $trial = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('trials.create', compact('case_id', 'case_name', 'trial'));
    }

    /**
     * Store a newly created trial in storage.
     */
    public function store(Request $request)
{
    try {
        // Validate request data
        $validatedData = $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'trial_date' => 'required|date_format:Y-m-d\TH:i',
            'judgement_details' => 'nullable|string',
            'judgement_date' => 'required|date_format:Y-m-d\TH:i|after_or_equal:trial_date',
            'final_outcome' => 'required|string|in:Win,Loss,Dismissed,Settled,Other',
            'final_outcome_other' => 'required_if:final_outcome,Other|string|nullable',
            'trialAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // File validation
        ]);

        Log::info('Trial Request Data:', $request->all());
        $dateJudgementTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->judgement_date);
        $judgement_date= $dateJudgementTime->toDateString();
        $judgement_time = $dateJudgementTime->toTimeString();

         $finalOutcome = $request->final_outcome === 'Other'
                ? $request->final_outcome_other
                : $request->final_outcome;
                
        $dateTrialTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->trial_date);
        $trial_date= $dateTrialTime->toDateString();
        $trial_time = $dateTrialTime->toTimeString();
        // Create the trial record
        $trial = Trial::create([
            'case_id' => $request->case_id,
            'trial_date' => $trial_date,
            'trial_time' => $trial_time,
            'judgement_details' => $request->judgement_details,
            'judgement_date' => $judgement_date,
            'judgement_time' => $judgement_time,
            'outcome' => $finalOutcome,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Log::info('Trial Created:', $trial->toArray());

        // Handle file uploads
        if ($request->hasFile('trialAttachments')) {
            foreach ($request->file('trialAttachments') as $file) {
                $filePath = $file->store('public/trial_attachments');
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();

                TrialAttachment::create([
                    'trial_id' => $trial->trial_id,
                    'file_name' => $fileName,
                    'file_path' => str_replace('public/', 'storage/', $filePath),
                    'file_type' => $fileType,
                    'upload_date' => now()
                ]);
            }
        }

       
        $case = CaseModel::find($request->case_id);
        if ($case) {
          
 // Assuming you want to set the case status to "Scheduled" when a hearing is added
            $case->case_status = "Under Negotiation"; // Change this as needed
            $case->save();
        } 

        return redirect()->route('trials.index', ['case_id' => $request->case_id])
                         ->with('success', 'Trial created successfully.');

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}


    /**
     * Display the specified trial.
     */
    public function show($trial_id)
    {
        try{
            $trial = Trial::with('attachments')->where('trial_id', $trial_id)->firstOrFail();
            Log::info('', $trial->toArray());
            
            $formattedJudgementDateTime = $trial->judgement_date && $trial->judgement_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$trial->judgement_date $trial->judgement_time")->format('Y-m-d\TH:i')
            : '';
            $formattedTrialDateTime = $trial->trial_date && $trial->trial_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$trial->trial_date $trial->trial_time")->format('Y-m-d\TH:i')
            : '';
            
            return response()->json([
                'case_name' => $trial->case->case_name,
                'trial' => $trial,
                'formattedJudgementDateTime'=> $formattedJudgementDateTime,
                'formattedTrialDateTime'=> $formattedTrialDateTime,
                'attachments' => $trial->attachments,
            ]);
        }
        catch (\Exception $e) {
            Log::info("The show function is not working");

            Log::error($e->getMessage());
        }
        
        
    }

    /**
     * Show the form for editing the specified trial.
     */
    public function edit($id)
    {
        $trial = Trial::findOrFail($id);
        return view('trials.edit', compact('trial'));
    }

    /**
     * Update the specified trial in storage.
     */
    public function update(Request $request)
{
    Log::info('Received Data:', $request->all());

    $trial = Trial::find($request->trial_id);

    if (!$trial) {
        Log::error("Trial not found for ID: " . $request->trial_id);
        return response()->json(['error' => 'Trial not found.'], 404);
    }

    try {
        // Validate request data
        $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'trial_date' => 'required|date_format:Y-m-d\TH:i',
            'judgement_date' => 'required|date_format:Y-m-d\TH:i|after_or_equal:trial_date',
            'judgement_details' => 'nullable|string',
            'outcome' => 'required|string|in:Win,Loss,Adjourned',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
        ]);
        $dateJudgementTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->judgement_date);
        $judgement_date= $dateJudgementTime->toDateString();
        $judgement_time = $dateJudgementTime->toTimeString();


        $dateTrialTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->trial_date);
        $trial_date= $dateTrialTime->toDateString();
        $trial_time = $dateTrialTime->toTimeString();
        // Update trial details
        $trial->update([
            'case_id' => $request->case_id,
            'trial_date' => $trial_date,
            'trial_time' => $trial_time,
            'judgement_date' => $request->judgement_date,
            'judgement_time' => $judgement_time,
            'judgement_details' => $request->judgement_details,
            'outcome' => $request->outcome,
            'updated_at' => now(),
        ]);

        Log::info("Updated Trial: ", [$trial]);

        /*
        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->store('public/trial_attachments');
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();

                TrialAttachment::create([
                    'trial_id' => $trial->trial_id,
                    'file_name' => $fileName,
                    'file_path' => str_replace('public/', 'storage/', $filePath),
                    'file_type' => $fileType,
                    'upload_date' => now()
                ]);
            }
        }
            */

        return response()->json(['message' => 'Trial updated successfully.']);

    } catch (\Exception $e) {
        Log::error("Update failed: " . $e->getMessage());
        return response()->json(['error' => 'Failed to update Trial.'], 500);
    }
}


    /**
     * Remove the specified trial from storage.
     */
    public function destroy($id)
    {
        Trial::findOrFail($id)->delete();
        return redirect()->route('trials.index')->with('success', 'Trial deleted successfully.');
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

            $latestAppeal = $case->appeals()->latest()->first(); // Fetch latest negotiation
    
            if ($latestAppeal) {
                return response()->json([
                    'exists' => true,
                    'case_id' => $case->case_id,
                    'case_name' => $case->case_name,
                    'negotiation' => [
                        'id' => $latestAppeal->appeal_id,
                        'edit_url' => route('negotiations.edit', $latestAppeal) // Generate edit URL
                    ]
                ]);
            }
                */
    
            // Case found - return JSON response instead of redirect
            return response()->json([
                'exists' => true,
                'case_id' => $case->case_id,
                'case_name' => $case->case_name,
                'trial' => null
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }



    


    public function deleteDocument($documentId)
    {
        Log::info('The document having an id of '. $documentId .' has been deleted ');
        
        try{
            $document = TrialAttachment::where('attachment_id', $documentId)->firstOrFail();
    
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
    
        // Delete the file from storage
        // Check if file_path is not null before deleting
    
         Log::info('The document path is: '. $document->file_path);
        if (!empty($document->file_path)) {
            Storage::delete($document->file_path); // Delete from storage
        }
    
    
        // Delete the record from the database
        $document->delete();
    
       
    
        return response()->json(['message' => 'Document deleted successfully.'], 200);
    }
        catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete document: ' . $e->getMessage()], 500);
        }  
    }
    
    
    public function uploadAttachment(Request $request)
    {
       Log::info('Received Data:', $request->all()); 
       try{
        $request->validate([
            'trial_id' => 'required|exists:trials,trial_id',
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jp eg,png|max:4096',
        ]);
    
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('trial_attachments', 'public'); // Save to storage/app/public/adjourn_attachments
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
    
            $document = TrialAttachment::create([
                'trial_id' => $request->trial_id,
                'file_name' => $fileName,
                'file_path' => str_replace('public/', 'storage/', $filePath),
                'file_type' => $fileType,
                'upload_date' => now()
    
            ]);
    
            return response()->json([
                'message' => 'Document uploaded successfully!',
                'document' => $document
            ]);
        }
    
       }
        catch (\Exception $e) {
            Log::error("Not working");
    
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to upload file'], 500);
        }
    
       
    }

}

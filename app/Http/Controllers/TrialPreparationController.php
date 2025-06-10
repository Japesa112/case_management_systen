<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrialPreparation;
use Illuminate\Support\Facades\Storage;
use App\Models\TrialPreparationAttachment;
use Illuminate\Support\Facades\Log;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseLawyer;


class TrialPreparationController extends Controller
{
    /**
     * Display a listing of the trial preparations.
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

            // Get trial preparations where the case_id is one of the lawyer's assigned ones
            $trialPreparations = TrialPreparation::with(['case', 'lawyer'])
                ->whereIn('case_id', $caseIds)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // For non-lawyers, show all
            $trialPreparations = TrialPreparation::with(['case', 'lawyer'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('preparations.index', compact('trialPreparations'));
    }
    /**
     * Show the form for creating a new trial preparation.
     */
    public function create($case_id) {
        $case_name = null;
        $preparation = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('preparations.create', compact('case_id', 'case_name', 'preparation'));
    }
    
    /**
     * Store a newly created trial preparation in storage.
     */
    public function store(Request $request)
{
    try {
        // Validate request data
        $validatedData = $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'preparation_date' =>  'required|date_format:Y-m-d\TH:i',
            'briefing_notes' => 'nullable|string',
            'preparation_status' => 'required|string|in:Pending,Ongoing,Completed',
            'modalAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
        ]);

        Log::info('Trial Preparation Request Data:', $request->all());
        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->preparation_date);
        $preparation_date= $dateTime->toDateString();
        $preparation_time = $dateTime->toTimeString();
        // Create the trial preparation record
        $trialPreparation = TrialPreparation::create([
            'case_id' => $request->case_id,
            'preparation_date' => $preparation_date,
            'preparation_time' => $preparation_time,           
            'briefing_notes' => $request->briefing_notes,
            'preparation_status' => $request->preparation_status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Log::info('Trial Preparation Created:', $trialPreparation->toArray());

        // Handle file uploads
        if ($request->hasFile('modalAttachments')) {
            foreach ($request->file('modalAttachments') as $file) {
                $filePath = $file->store('public/trial_preparation_attachments');
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();

                TrialPreparationAttachment::create([
                    'preparation_id' => $trialPreparation->preparation_id,
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
            $case->case_status = "Under Panel Evaluation"; // Change this as needed
            $case->save();
        } 


        return redirect()->route('preparations.index', [
            'case_id' => $request->case_id,
            'preparation' => $trialPreparation->preparation_id
        ])->with('preparation_success', true)
          ->with('success', 'Trial Preparation created successfully.');

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}


    /**
     * Display the specified trial preparation.
     */
    public function show($preparation_id)
    {
        try{
            $preparation = TrialPreparation::with('attachments')->where('preparation_id', $preparation_id)->firstOrFail();
            Log::info('', $preparation->toArray());
            
            $formattedDateTime = $preparation->preparation_date && $preparation->preparation_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$preparation->preparation_date $preparation->preparation_time")->format('Y-m-d\TH:i')
            : '';
            return response()->json([
                'case_name' => $preparation->case->case_name,
                'formattedDateTime' => $formattedDateTime,
                'preparation' => $preparation,
                'attachments' => $preparation->attachments,
            ]);
        }
        catch (\Exception $e) {
            Log::info("The show function is not working");

            Log::error($e->getMessage());
        }
        
        
    }

    /**
     * Show the form for editing the specified trial preparation.
     */
    public function edit($id)
    {
        $trialPreparation = TrialPreparation::findOrFail($id);
        return view('preparations.edit', compact('trialPreparation'));
    }

    /**
     * Update the specified trial preparation in storage.
     */
    public function update(Request $request)
    {
        Log::info('Received Data:', $request->all());
    
        $trialPreparation = TrialPreparation::find($request->preparation_id);
    
        if (!$trialPreparation) {
            Log::error("Trial Preparation not found for ID: " . $request->preparation_id);
            return response()->json(['error' => 'Trial Preparation not found.'], 404);
        }
    
        try {
            $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'preparation_date' =>'required|date_format:Y-m-d\TH:i',
                'briefing_notes' => 'nullable|string',
                'preparation_status' => 'required|string',
            ]);
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->preparation_date);
            $preparation_date= $dateTime->toDateString();
            $preparation_time = $dateTime->toTimeString();
            $trialPreparation->update([
                'case_id' => $request->case_id,
                'preparation_date' => $preparation_date,
                'preparation_time' => $preparation_time,   
                'briefing_notes' => $request->briefing_notes,
                'preparation_status' => $request->preparation_status,
                'updated_at' => now(),
            ]);
    
            Log::info("Updated Trial Preparation: ", [$trialPreparation]);
    
            return response()->json(['message' => 'Trial Preparation updated successfully.']);
    
        } catch (\Exception $e) {
            Log::error("Update failed: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update Trial Preparation.'], 500);
        }
    }
    

    /**
     * Remove the specified trial preparation from storage.
     */
    public function destroy($id)
    {
        TrialPreparation::findOrFail($id)->delete();
        return redirect()->route('trial_preparations.index')->with('success', 'Trial Preparation deleted successfully.');
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
                'preparation' => null
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
            $document = TrialPreparationAttachment::where('attachment_id', $documentId)->firstOrFail();
    
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
            'preparation_id' => 'required|exists:trial_preparations,preparation_id',
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jp eg,png|max:4096',
        ]);
    
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('trial_preparation_attachments', 'public'); // Save to storage/app/public/adjourn_attachments
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
    
            $document = TrialPreparationAttachment::create([
                'preparation_id' => $request->preparation_id,
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

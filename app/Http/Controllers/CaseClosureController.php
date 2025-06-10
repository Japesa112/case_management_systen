<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseClosure;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseClosureAttachment;
use Illuminate\Support\Facades\Log;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;

class CaseClosureController extends Controller
{
    /**
     * Display a listing of case closures.
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

        // Get only case_ids assigned to this lawyer
        $caseIds = \App\Models\CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');

        // Fetch only closed cases for these case_ids
        $closedCases = \App\Models\CaseClosure::with('case')
            ->whereIn('case_id', $caseIds)
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        // Non-lawyers see all closed cases
        $closedCases = \App\Models\CaseClosure::with('case')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return view('closed_cases.index', compact('closedCases'));
}


    /**
     * Show the form for creating a new case closure.
     */
    public function create($case_id)
    {
        $case_name = null;
        $caseClosure = null;

        if ($case_id) {
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
            }
        }

        return view('closed_cases.create', compact('case_id', 'case_name', 'caseClosure'));
    }

    /**
     * Store a newly created case closure in storage.
     */
    public function store(Request $request) 
    {
        try {
            $validatedData = $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'closure_date' => 'required|date',
                'final_outcome' => 'required|string|in:Win,Loss,Dismissed,Settled',
                'follow_up_actions' => 'nullable|string',
                'lawyer_payment_confirmed' => 'required|string|in:Yes,No',
                'closureAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048'
            ]);
    
            Log::info('Case Closure Request Data:', $request->all());
    
            // Create case closure record
            $caseClosure = CaseClosure::create([
                'case_id' => $request->case_id,
                'closure_date' => $request->closure_date,
                'final_outcome' => $request->final_outcome,
                'follow_up_actions' => $request->follow_up_actions,
                'lawyer_payment_confirmed' => $request->lawyer_payment_confirmed,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            Log::info('Case Closure Created:', $caseClosure->toArray());
    
            // Handle file uploads
            if ($request->hasFile('closureAttachments')) {
                foreach ($request->file('closureAttachments') as $file) {
                    $filePath = $file->store('public/case_closure_attachments');
                    $fileName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension();
    
                    CaseClosureAttachment::create([
                        'caseclosure_id' => $caseClosure->closure_id,
                        'file_name' => $fileName,
                        'file_path' => str_replace('public/', 'storage/', $filePath),
                        'file_type' => $fileType,
                        'upload_date' => now()
                    ]);
                }
            }
            $case = CaseModel::find( $request->case_id);
            if ($case) {
              
     // Assuming you want to set the case status to "Scheduled" when a hearing is added
                $case->case_status = "Closed"; // Change this as needed
                $case->save();
            }
        
    
            return redirect()->route('closed_cases.index')->with('success', 'Case closure recorded successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    

    /**
     * Display the specified case closure.
     */
    public function show($closure_id)
    {
        try{
            $closure =CaseClosure::with('attachments')->where('closure_id', $closure_id)->firstOrFail();
            Log::info('', $closure->toArray());
            return response()->json([
                'case_name' => $closure->case->case_name,
                'closure' => $closure,
                'attachments' => $closure->attachments,
            ]);
        }
        catch (\Exception $e) {
            Log::info("The show function is not working");

            Log::error($e->getMessage());
        }
        
        
    }

    /**
     * Show the form for editing the specified case closure.
     */

    public function edit($id)
    {
        $caseClosure = CaseClosure::findOrFail($id);
        return view('caseClosures.edit', compact('caseClosure'));
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
                'caseClosure' => null
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified case closure in storage.
     */
    public function update(Request $request)
    {
        $caseClosure = CaseClosure::find($request->closure_id);
    
        if (!$caseClosure) {
            return response()->json(['error' => 'Case Closure not found.'], 404);
        }

        Log::info("The data received is: ".$caseClosure->closure_id);
    
        try {
            $validatedData = $request->validate([
                'closure_date' => 'required|date',
                'final_outcome' => 'required|string',
                'follow_up_actions' => 'nullable|string',
                'lawyer_payment_confirmed' => 'required|in:Yes,No',
               
            ]);
    
            // Update case closure details
            $caseClosure->update([
                'closure_date' => $validatedData['closure_date'],
                'final_outcome' => $validatedData['final_outcome'],                
                'follow_up_actions' => $validatedData['follow_up_actions'] ?? null,
                'lawyer_payment_confirmed' => $validatedData['lawyer_payment_confirmed'],
                'updated_at' => now(),
            ]);
            
            /*
            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filePath = $file->store('public/case_closure_attachments');
                    $fileName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension();
    
                    CaseClosureAttachment::create([
                        'case_closure_id' => $caseClosure->closure_id,
                        'file_name' => $fileName,
                        'file_path' => str_replace('public/', 'storage/', $filePath),
                        'file_type' => $fileType,
                        'upload_date' => now(),
                    ]);
                }
            }
                */
    
            return response()->json(['message' => 'Case Closure updated successfully.']);
        } catch (\Exception $e) {
            Log::info("This is not working see the error below");
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to update Case Closure.'], 500);
        }
    }
    
    /**
     * Remove the specified case closure from storage.
     */
    public function destroy($id)
    {
        CaseClosure::findOrFail($id)->delete();
        return redirect()->route('caseClosures.index')->with('success', 'Case Closure deleted successfully.');
    }

    public function deleteDocument($documentId)
    {
        try {
            $document = CaseClosureAttachment::where('attachment_id', $documentId)->firstOrFail();
            if (!empty($document->file_path)) {
                Storage::delete($document->file_path);
            }
            $document->delete();
            return response()->json(['message' => 'Document deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete document.'], 500);
        }
    }

    public function uploadAttachment(Request $request)
    {
        try {
            $request->validate([
                'case_closure_id' => 'required|exists:caseclosures,closure_id',
                'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:4096',
            ]);

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filePath = $file->store('case_closure_attachments', 'public');
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();

                $document = CaseClosureAttachment::create([
                    'caseclosure_id' => $request->case_closure_id,
                    'file_name' => $fileName,
                    'file_path' => str_replace('public/', 'storage/', $filePath),
                    'file_type' => $fileType,
                    'upload_date' => now()
                ]);

                return response()->json(['message' => 'Document uploaded successfully!', 'document' => $document]);
            }
        } catch (\Exception $e) {

            Log::info("This is not working");
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to upload file'], 500);
        }
    }
}

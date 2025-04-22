<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adjourn;
use App\Models\AdjournAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdjournController extends Controller
{
    /**
     * Display a list of adjournments.
     */
    public function index()
    {
        $adjourns = Adjourn::with('attachments')->get();
        return view('adjourns.index', compact('adjourns'));
    }

    public function create($case_id) {
        $case_name = null;
        $adjourn = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('adjourns.create', compact('case_id', 'case_name', 'adjourn'));
    }
    

    /**
     * Store a new adjournment.
     */
    public function store(Request $request)
    {
        try {
            // Validate adjourn data
            $validatedData = $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'next_hearing_date' => 'nullable|date',
                'adjourn_comments' => 'nullable|string',
                'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
            ]);
    
            Log::info('Request Data:', $request->all());
    
            // Create the adjourn
            $adjourn = Adjourn::create([
                'case_id' => $request->case_id,
                'next_hearing_date' => $request->next_hearing_date,
                'adjourn_comments' => $request->adjourn_comments,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            Log::info('Adjourn Created:', $adjourn->toArray());
    
            // Handle file uploads
            if ($request->hasFile('modalAttachments')) {
                foreach ($request->file('modalAttachments') as $file) {
                    $filePath = $file->store('public/adjourn_attachments');
                    $fileName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension();
    
                    AdjournAttachment::create([
                        'adjourns_id' => $adjourn->adjourns_id,
                        'file_name' => $fileName,
                        'file_path' => str_replace('public/', 'storage/', $filePath),
                        'file_type' => $fileType,
                        'upload_date' => now()
                    ]);
                }
            }
    
            return redirect()->route('adjourns.index', [
                'case_id' => $request->case_id, 
                'adjourn' => $adjourn->adjourn_id
            ])->with('adjourn_success', true)
            ->with('success', 'The adjourn Added successfully');
            ;
    
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function show($adjourns_id)
    {
        $adjourn = Adjourn::with('attachments')->where('adjourns_id', $adjourns_id)->firstOrFail();
    
        return response()->json([
            'case_name' => $adjourn->case->case_name,
            'adjourn' => $adjourn,
            'attachments' => $adjourn->attachments,
        ]);
    }
    
    /**
     * Update an adjournment.
     */
    public function update(Request $request, Adjourn $adjourn)
    {
        Log::info('Received Data:', $request->all()); 
        try{
            $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'next_hearing_date' => 'nullable|date',
                'appeal_comments' => 'nullable|string',
            ]);
        
            $adjourn->update([
                'case_id' => $request->case_id,
                'next_hearing_date' => $request->next_hearing_date,
                'adjourn_comments' => $request->adjourn_comments,
            ]);
            
        
            return response()->json(['message' => 'Adjourn updated successfully.']);
        }
        catch (\Exception $e) {
            Log::error("The update is not working");
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to Update Adjourn ' . $e->getMessage()], 500);
        }  
    }
    

    /**
     * Delete an adjournment.
     */
    public function destroy(Adjourn $adjourn)
    {
        $adjourn->delete();
        return redirect()->back()->with('success', 'Adjournment deleted successfully.');
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
                'adjourn' => null
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
            $document = AdjournAttachment::where('attachment_id', $documentId)->firstOrFail();
    
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
            'adjourns_id' => 'required|exists:adjourns,adjourns_id',
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('adjourn_attachments', 'public'); // Save to storage/app/public/adjourn_attachments
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
    
            $document = AdjournAttachment::create([
                'adjourns_id' => $request->adjourns_id,
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
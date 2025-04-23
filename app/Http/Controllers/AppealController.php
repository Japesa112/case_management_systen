<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;
use Illuminate\Support\Facades\Log;
use App\Models\AppealAttachment;
use Illuminate\Support\Facades\Storage;
class AppealController extends Controller
{
    public function index()
    {
        $appeals = Appeal::with(['case', 'attachments'])->get();
        return view('appeals.index', compact('appeals'));

    }

    
        public function create($case_id) {
            $case_name = null;
            $appeal = null;

            if ($case_id) {
                // Retrieve the case record based on the provided case_id
                $caseRecord = \App\Models\CaseModel::find($case_id);
                if ($caseRecord) {
                    $case_name = $caseRecord->case_name;
                   // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
        
                }
            }

            return view('appeals.create', compact('case_id', 'case_name', 'appeal'));
        }
        
    

        public function store(Request $request)
        {
            try {
                // Validate appeal data
                $validatedData = $request->validate([
                    'case_id' => 'required|exists:cases,case_id',
                    'next_hearing_date' => 'required|date_format:Y-m-d\TH:i',
                    'appeal_comments' => 'nullable|string',
                    'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
                ]);
        
                Log::info('Request Data:', $request->all());
                $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->next_hearing_date);
                $next_hearing_date = $dateTime->toDateString();
                $next_hearing_time = $dateTime->toTimeString();
                // Create the appeal
                $appeal = Appeal::create([
                    'case_id' => $request->case_id,
                    'next_hearing_date' => $next_hearing_date,
                    'next_hearing_time' => $next_hearing_time,
                    'appeal_comments' => $request->appeal_comments,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        
                Log::info('Appeal Created:', $appeal->toArray());
        
                // Handle file uploads
                if ($request->hasFile('modalAttachments')) {
                    foreach ($request->file('modalAttachments') as $file) {
                        $filePath = $file->store('public/appeal_attachments');
                        $fileName = $file->getClientOriginalName();
                        $fileType = $file->getClientOriginalExtension();
        
                        AppealAttachment::create([
                            'appeal_id' => $appeal->appeal_id,
                            'file_name' => $fileName,
                            'file_path' => str_replace('public/', 'storage/', $filePath),
                            'file_type' => $fileType,
                            'upload_date' => now()
                        ]);
                    }
                }
        
                return redirect()->route('appeals.index', [
                    'case_id' => $request->case_id, 
                    'appeal' => $appeal->appeal_id
                ])->with('appeal_success', true)
                ->with('success', 'The Appeal Added successfully');
                ;
        
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }
        

        public function show($appeal_id)
        {
            $appeal = Appeal::with('attachments')->where('appeal_id', $appeal_id)->firstOrFail();
            $formattedDateTime = $appeal->next_hearing_date && $appeal->next_hearing_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$appeal->next_hearing_date $appeal->next_hearing_time")->format('Y-m-d\TH:i')
            : '';
            return response()->json([
                'case_name' => $appeal->case->case_name,
                'formattedDateTime'=> $formattedDateTime,
                'appeal' => $appeal,
                'attachments' => $appeal->attachments,
            ]);
        }
        

    public function edit(Appeal $appeal)
    {
        return view('appeals.edit', compact('appeal'));
    }

    public function update(Request $request, Appeal $appeal)
{
    Log::info('Received Data:', $request->all()); 
    try{
        $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'next_hearing_date' => 'required|date_format:Y-m-d\TH:i',
            'appeal_comments' => 'nullable|string',
        ]);

        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->next_hearing_date);
        $next_hearing_date = $dateTime->toDateString();
        $next_hearing_time = $dateTime->toTimeString();
                // Create the appeal
    
        $appeal->update([
            'case_id' => $request->case_id,
            'next_hearing_date' => $next_hearing_date,
            'next_hearing_time' => $next_hearing_time,
            'appeal_comments' => $request->appeal_comments,
        ]);
        
    
        return response()->json(['message' => 'Appeal updated successfully.']);
    }
    catch (\Exception $e) {
        Log::error("The update is not working");
        Log::error($e->getMessage());
        return response()->json(['error' => 'Failed to Update Appeal ' . $e->getMessage()], 500);
    }  
}

    public function destroy(Appeal $appeal)
    {
        $appeal->delete();
        return redirect()->route('appeals.index')->with('success', 'Appeal deleted successfully.');
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
            
    
            // Case found - return JSON response instead of redirect
            return response()->json([
                'exists' => true,
                'case_id' => $case->case_id,
                'case_name' => $case->case_name,
                'appeal' => null
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
        $document = AppealAttachment::where('attachment_id', $documentId)->firstOrFail();

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
   
   try{
    $request->validate([
        'appeal_id' => 'required|exists:appeal,appeal_id',
        'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filePath = $file->store('appeal_attachments', 'public'); // Save to storage/app/public/appeal_attachments
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();

        $document = AppealAttachment::create([
            'appeal_id' => $request->appeal_id,
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

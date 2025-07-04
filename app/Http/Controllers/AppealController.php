<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;
use Illuminate\Support\Facades\Log;
use App\Models\AppealAttachment;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class AppealController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
    }

    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === 'Lawyer') {
            $lawyerId = $user->lawyer->lawyer_id ?? null;

            // Get case_ids assigned to this lawyer
            $caseIds = \App\Models\CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');

            // Filter appeals for those cases
            $appeals = \App\Models\Appeal::with(['case', 'attachments'])
                ->whereIn('case_id', $caseIds)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Non-lawyers see all appeals
            $appeals = \App\Models\Appeal::with(['case', 'attachments'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

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
                       

                        $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                        Log::info("time is: ".time());

                        $file->storeAs('public/appeal_attachments', $uniqueFileName);
        
                        AppealAttachment::create([
                            'appeal_id' => $appeal->appeal_id,
                             'file_name' => $uniqueFileName, 
                            // Store the original name separately for user-friendly display.
                            // NOTE: This requires adding an 'original_name' column to your table.
                            'file_path' => $file->getClientOriginalName(),
                            'file_type' => $file->getClientMimeType(),
                            'upload_date' => now(),


                        ]);
                    }
                }

                $case = CaseModel::find( $request->case_id);
            if ($case) {
              
     // Assuming you want to set the case status to "Scheduled" when a hearing is added
                $case->case_status = "Appeal"; // Change this as needed
                $case->save();
            }

            // 🔔 Notification for Appeal
            $notification = Notification::create([
                'title'   => 'New Appeal Added',
                'message' => "An appeal has been added to the case: '{$case->case_name}'.",
                'type'    => 'appeal_created',
                'icon'    => 'fa fa-balance-scale', // Example icon
            ]);

            $totalNotified = 0;

            User::select('user_id')->chunkById(200, function ($users) use ($notification, &$totalNotified) {
                $now = now();
                $insertData = $users->map(function ($user) use ($notification, $now) {
                    return [
                        'user_id'         => $user->user_id,
                        'notification_id' => $notification->notification_id,
                        'is_read'         => false,
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                })->toArray();

                DB::table('user_notification')->insert($insertData);
                $totalNotified += count($insertData);
            });

            Log::info("Appeal notification sent to {$totalNotified} users", [
                'notification_id' => $notification->notification_id,
                'appeal_id' => $appeal->appeal_id
            ]);

        
        
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
        $notification = Notification::create([
                'title'   => 'New Appeal Updated',
                'message' => "An appeal for '{$appeal->case->case_name}' has been updated: .",
                'type'    => 'appeal_created',
                'icon'    => 'fa fa-balance-scale', // Example icon
            ]);

            $totalNotified = 0;

            User::select('user_id')->chunkById(200, function ($users) use ($notification, &$totalNotified) {
                $now = now();
                $insertData = $users->map(function ($user) use ($notification, $now) {
                    return [
                        'user_id'         => $user->user_id,
                        'notification_id' => $notification->notification_id,
                        'is_read'         => false,
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ];
                })->toArray();

                DB::table('user_notification')->insert($insertData);
                $totalNotified += count($insertData);
            });

            Log::info("Appeal notification sent to {$totalNotified} users", [
                'notification_id' => $notification->notification_id,
                'appeal_id' => $appeal->appeal_id
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
         $uniqueFileName = time() . '_' . $file->getClientOriginalName();

        Log::info("time is: ".time());

        $file->storeAs('public/appeal_attachments', $uniqueFileName);

        $document = AppealAttachment::create([
            'appeal_id' => $request->appeal_id,
             'file_name' => $uniqueFileName, 
                    // Store the original name separately for user-friendly display.
                    // NOTE: This requires adding an 'original_name' column to your table.
            'file_path' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'upload_date' => now(),

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

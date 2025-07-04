<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adjourn;
use App\Models\AdjournAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class AdjournController extends Controller
{
    /**
     * Display a list of adjournments.
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

            // Get case_ids assigned to this lawyer
            $caseIds = \App\Models\CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');

            // Fetch only adjournments related to those cases
            $adjourns = \App\Models\Adjourn::with('attachments')
                ->whereIn('case_id', $caseIds)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // For other roles, show all adjournments
            $adjourns = \App\Models\Adjourn::with('attachments')
                ->orderBy('created_at', 'desc')
                ->get();
        }

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
                'next_hearing_date' => 'required|date_format:Y-m-d\TH:i',
                'adjourn_comments' => 'nullable|string',
                'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
            ]);
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->next_hearing_date);
            $next_hearing_date = $dateTime->toDateString();
            $next_hearing_time = $dateTime->toTimeString();
    
            Log::info('Request Data:', $request->all());
    
            // Create the adjourn
            $adjourn = Adjourn::create([
                'case_id' => $request->case_id,
                'next_hearing_date' => $next_hearing_date,
                'next_hearing_time' => $next_hearing_time,
                'adjourn_comments' => $request->adjourn_comments,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            Log::info('Adjourn Created:', $adjourn->toArray());
    
            // Handle file uploads
           // In your Controller
            if ($request->hasFile('modalAttachments')) {
                foreach ($request->file('modalAttachments') as $file) {
                    // 1. Create a unique, predictable filename that prevents overwrites.
                    $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                    // 2. Use storeAs() to save the file with our new unique name.
                    $file->storeAs('public/adjourn_attachments', $uniqueFileName);

                    // 3. Save the details to the database. Store the new unique name.
                    AdjournAttachment::create([
                        'adjourns_id' => $adjourn->adjourns_id,
                        // We store the UNIQUE name, which matches the file on disk.
                        'file_name' => $uniqueFileName,
                        // It's also great practice to store the original name for display purposes.
                        'file_path' => $file->getClientOriginalName(), 
                        // We NO LONGER need a 'file_path' column!
                        'file_type' => $file->getClientOriginalExtension(),
                        'upload_date' => now()
                    ]);
                }
            }
                        $case = CaseModel::find($request->case_id);
            if ($case) {
              
     // Assuming you want to set the case status to "Scheduled" when a hearing is added
                $case->case_status = "Adjourned"; // Change this as needed
                $case->save();
            }

            // 🔔 Notification logic
            $notification = Notification::create([
                'title'   => 'Case Adjourned',
                'message' => "The case '{$case->case_name}' has been adjourned.",
                'type'    => 'case_adjourned',
                'icon'    => 'fa fa-clock' // Choose appropriate icon
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

            Log::info("Adjournment notification sent to {$totalNotified} users", [
                'notification_id' => $notification->notification_id,
                'adjourn_id'      => $adjourn->adjourns_id
            ]);

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
        $formattedDateTime = $adjourn->next_hearing_date && $adjourn->next_hearing_time
        ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$adjourn->next_hearing_date $adjourn->next_hearing_time")->format('Y-m-d\TH:i')
        : '';
        return response()->json([
            'case_name' => $adjourn->case->case_name,
            'adjourn' => $adjourn,
            'formattedDateTime'=> $formattedDateTime,
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
                'next_hearing_date' => 'required|date_format:Y-m-d\TH:i',
                'appeal_comments' => 'nullable|string',
            ]);
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->next_hearing_date);
            $next_hearing_date = $dateTime->toDateString();
            $next_hearing_time = $dateTime->toTimeString();
            $adjourn->update([
                'case_id' => $request->case_id,
                'next_hearing_date' => $next_hearing_date,
                'next_hearing_time' => $next_hearing_time,
                'adjourn_comments' => $request->adjourn_comments,
            ]);

             // 🔔 Notification logic
            $case = CaseModel::find($request->case_id);

            if ($case) {
                $notification = Notification::create([
                    'title'   => 'Adjournment Updated',
                    'message' => "The adjournment for case '{$case->case_name}' has been updated.",
                    'type'    => 'adjournment_updated',
                    'icon'    => 'fa fa-pen' // Choose an appropriate icon
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

                Log::info("Adjournment update notification sent to {$totalNotified} users", [
                    'notification_id' => $notification->notification_id,
                    'adjourn_id'      => $adjourn->adjourns_id
                ]);
            }
            
        
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
            $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                Log::info("time is: ".time());

                $file->storeAs('public/adjourn_attachments', $uniqueFileName);
    
            $document =  AdjournAttachment::create([
                    'adjourns_id' => $request->adjourns_id,
                    // Store the UNIQUE filename. This is the source of truth.
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
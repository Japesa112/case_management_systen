<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DvcAppointment;
use App\Models\DvcAppointmentAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseModel;
use App\Mail\LawyerAssignedNotification;
use App\Models\CaseLawyer;
use App\Models\Lawyer;

use App\Models\PanelEvaluation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;

class DvcAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
    }
    
   public function index()
    {
        $user = Auth::user();

        // Block access for lawyers entirely
        if ($user && $user->role === 'Lawyer') {
            abort(403, 'Unauthorized access. Lawyers cannot view this page.');
        }

        $appointments = DvcAppointment::orderBy('created_at', 'desc')->get();

        return view('dvc.index', compact('appointments'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($case_id, $forwarding_id, $evaluation_id)
    {
        //
         $case_name = null;
         $appointment = null;

            if ($case_id) {
                // Retrieve the case record based on the provided case_id
                $caseRecord = \App\Models\CaseModel::find($case_id);
                if ($caseRecord) {
                    $case_name = $caseRecord->case_name;
                   // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
        
                }
            }

            return view('dvc.create', compact('case_id', 'evaluation_id', 'forwarding_id', 'case_name', 'appointment'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        try {
                // Validate appeal data
                $validatedData = $request->validate([
                    'forwarding_id'=> 'required|exists:forwardings,forwarding_id',
                    'evaluation_id'=> 'required|exists:evaluations,evaluation_id',
                    'case_id' => 'required|exists:cases,case_id',
                    'next_hearing_date' => 'required|date_format:Y-m-d\TH:i',
                    'comments' => 'nullable|string',
                    'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
                ]);
        
                Log::info('Request Data:', $request->all());

                $evaluation = PanelEvaluation::findOrFail($request->evaluation_id);
                $caseId = $evaluation->case_id;
                $userId = $evaluation->lawyer_id;
                $lawyerId = User::find($userId)?->lawyer?->lawyer_id;



                $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->next_hearing_date);
                $appointment_date = $dateTime->toDateString();
                $appointment_time = $dateTime->toTimeString();
                // Create the appeal
                $appointment = DvcAppointment::create([
                    'forwarding_id' => $request->forwarding_id,
                    'evaluation_id' => $request->evaluation_id,
                    'case_id' => $request->case_id,
                    'appointment_date' => $appointment_date,
                    'appointment_time' => $appointment_time,
                    'comments' => $request->comments,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        
                Log::info('Appointment Created:', $appointment->toArray());

                                // Store in CaseLawyer if not already assigned
                $existingAssignment = CaseLawyer::where('case_id', $caseId)
                    ->where('lawyer_id', $lawyerId)
                    ->first();

               

                if (!$existingAssignment) {
                    CaseLawyer::create([
                        'case_id' => $caseId,
                        'lawyer_id' => $lawyerId
                    ]);
                }

        
                // Handle file uploads
                if ($request->hasFile('modalAttachments')) {
                    foreach ($request->file('modalAttachments') as $file) {
                        $filePath = $file->store('public/appointment_attachments');
                        $fileName = $file->getClientOriginalName();
                        $fileType = $file->getClientOriginalExtension();
        
                        DvcAppointmentAttachment::create([
                            'appointment_id' => $appointment->appointment_id,
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
                $case->case_status = "Assignment"; // Change this as needed
                $case->save();
            }



            $case = \App\Models\CaseModel::find($request->case_id);
            $lawyer = \App\User::find(3);

            if ($case && $lawyer) {
                
                // Send the email immediately (no queue)
                Mail::to($lawyer->email)->send(new LawyerAssignedNotification($case, $lawyer));

                Log::info("Lawyer assigned and notified via email (no queue)", [
                    'case_id' => $case->case_id,
                    'lawyer_email' => $lawyer->email
                ]);


                // 🔔 Create a system notification
                $notification = Notification::create([
                    'title'   => 'Lawyer Assigned to Case',
                    'message' => "You have been assigned to Case #{$case->case_id}. Please review the DVC appointment details.",
                    'type'    => 'lawyer_assignment',
                    'icon'    => 'fa fa-briefcase',
                ]);

                // Link notification to the lawyer
                DB::table('user_notification')->insert([
                    'user_id'         => $lawyer->user_id,
                    'notification_id' => $notification->notification_id,
                    'is_read'         => false,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                Log::info("Notification created and linked to lawyer", [
                    'user_id' => $lawyer->user_id,
                    'notification_id' => $notification->notification_id,
                ]);
            }
        
        
                return redirect()->route('dvc.index', [
                    'case_id' => $request->case_id, 
                    'appointment' => $appointment->appointment_id
                ])->with('appointment_success', true)
                ->with('success', 'The appointment sent successfully');
                ;
        
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show($appointment_id)
    {
        //
         $appointment = DvcAppointment::with('attachments')->where('appointment_id', $appointment_id)->firstOrFail();
            $formattedDateTime = $appointment->appointment_date && $appointment->appointment_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$appointment->appointment_date $appointment->appointment_time")->format('Y-m-d\TH:i')
            : '';
            return response()->json([
                'case_name' => $appointment->evaluation->case->case_name,
                'case_id' => $appointment->evaluation->case->case_id,
                'formattedDateTime'=> $formattedDateTime,
                'appointment' => $appointment,
                'attachments' => $appointment->attachments,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DvcAppointment $appointment)
    {
        //
        Log::info('Received Data:', $request->all()); 
    try{
        $request->validate([
           'forwarding_id'=> 'required|exists:forwardings,forwarding_id',
            'evaluation_id'=> 'required|exists:evaluations,evaluation_id',
            'case_id' => 'required|exists:cases,case_id',
            'next_hearing_date' => 'required|date_format:Y-m-d\TH:i',
            'comments' => 'nullable|string',
        ]);

        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->next_hearing_date);
        $appointment_date = $dateTime->toDateString();
        $appointment_time = $dateTime->toTimeString();
                // Create the appeal
    
        $appointment->update([
                'forwarding_id' => $request->forwarding_id,
                'evaluation_id' => $request->evaluation_id,
                'case_id' => $request->case_id,
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time,
                'comments' => $request->comments,
        ]);
        
    
        return response()->json(['message' => 'Appointment updated successfully.']);
    }
    catch (\Exception $e) {
        Log::error("The update is not working");
        Log::error($e->getMessage());
        return response()->json(['error' => 'Failed to Update Appointment ' . $e->getMessage()], 500);
    }  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkCase(Request $request)
{
    try {
        $case_number = trim($request->case_number);

        // Find the case
        $case = \App\Models\CaseModel::whereRaw('LOWER(case_number) = ?', [strtolower($case_number)])->first();

        if (!$case) {
            return response()->json([
                'exists' => false,
                'message' => 'Case not found'
            ], 404);
        }

        // Attempt to get the latest forwarding and evaluation
        $forwarding = $case->forwardings()->latest()->first();
        $evaluation = $forwarding ? $forwarding->evaluation : null;

        if ($forwarding && $evaluation) {
            return response()->json([
                'exists' => true,
                'case_id' => $case->case_id,
                'forwarding_id' => $forwarding->forwarding_id,
                'evaluation_id' => $evaluation->evaluation_id,
                'case_name' => $case->case_name,
            ]);
        } else {
            return response()->json([
                'exists' => false,
                'message' => 'This case does not have a forwarding or evaluation record.'
            ], 422); // Unprocessable Entity
        }
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
        $document = DvcAppointmentAttachment::where('attachment_id', $documentId)->firstOrFail();

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
        'appointment_id' => 'required|exists:dvc_appointment,appointment_id',
        'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filePath = $file->store('appointment_attachments', 'public'); // Save to storage/app/public/appeal_attachments
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();

        $document = DvcAppointmentAttachment::create([
            'appointment_id' => $request->appointment_id,
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

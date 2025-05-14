<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseDocument;
use App\Models\Complainant;
use App\Models\CaseLawyer;
use App\Models\CaseActivity;
use App\Models\Lawyer;
use App\Models\Payment;
use App\Models\LawyerPayment;
use Carbon\Carbon;  // Import Carbon for handling timestamps
use App\Mail\TestEmail;
use App\Models\Appeal;
use App\Models\Forwarding;
use App\Models\AGAdvice;
use App\Models\Adjourn;
use App\Models\Negotiation;
use App\Models\TrialPreparation;
use App\Models\Trial;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Mail\NewCaseNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\helper\Events;


use App\Mail\CaseNotification;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $primaryKey = 'case_id'; // Ensure this matches your database column
    public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function index()
    {
        //
      $cases = CaseModel::orderBy('created_at', 'desc')->get(); // No paginate()

        foreach ($cases as $case) {
            if (Str::contains($case->case_status, '-')) {
                $parts = explode('-', $case->case_status);
               
                // add two new attributes:
              
                if (count($parts) == 2 && is_numeric($parts[0])) {
                    

                    $ordinal =$this->ordinalParts((int) $parts[0]);
                    $case->seq_num = $ordinal['number'];
                   $case->seq_suffix = $ordinal['suffix'];
                   $case->matter = $parts[1];

                } else {
                    $case->case_status_formatted = $case->case_status;
                }
            } else {
                $case->case_status_formatted = $case->case_status;
            }
        }
        return view("cases.index", compact('cases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('cases.create');

    }

    /**
     * Store a newly created resource in storage.
     */
   /*

    public function store(Request $request)
    {
 
        
        
        
       try {
        // Validate input
        $validatedData = $request->validate([
            'case_number'      => 'required|string|max:255|unique:cases,case_number',
            'case_name'        => 'required|string|max:255',
            'date_received'    => 'required|date',
            'case_description' => 'required|string',
            'case_status'      => 'required|in:Waiting for First Hearing,Under Review,Waiting for Panel Evaluation,Waiting for AG Advice,Forwarded to DVC,Under Trial,Judgement Rendered,Closed',
            'case_category'    => 'required|in:Academic,Disciplinary,Administrative,student,staff,supplier,staff union',
            'initial_status'   => 'required|in:Under Review,Approved,Rejected,Needs Negotiation',
            'first_hearing_date' => 'nullable|date',
        ]);

        

        $validatedData['created_by'] = Auth::id(); // Set logged-in user ID

        // Debugging: Uncomment this to check what data is being inserted
        // dd($validatedData);

        // Create case
        CaseModel::create($validatedData);

        return redirect()->route('cases.index')->with('success', 'Case Created Successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
    }

            
    }
    */



    public function checkAssignment($case_id)
{
    $isAssigned = CaseLawyer::where('case_id', $case_id)->exists();

    return response()->json(['assigned' => $isAssigned]);
}



    public function assignMultiple(Request $request)
{
    try {
        // Validate input
        $request->validate([
            'case_id' => 'required|integer',
            'lawyer_ids' => 'required|array',
            'lawyer_ids.*' => 'integer', // Ensure each lawyer_id is an integer
        ]);

        // Insert multiple records in the case_lawyer table
        $assignments = [];
        foreach ($request->lawyer_ids as $lawyerId) {
            $assignments[] = [
                'case_id' => $request->case_id,
                'lawyer_id' => $lawyerId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        CaseLawyer::insert($assignments); // Bulk insert

        return response()->json([
            'success' => true,
            'message' => 'Case assigned successfully to multiple lawyers!',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ], 500);
    }
}

    public function assign(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'case_id' => 'required|integer',
                'lawyer_id' => 'required|integer',
            ]);
    
            // Assign case to lawyer
            $caseLawyer = CaseLawyer::create([
                'case_id' => $request->case_id,
                'lawyer_id' => $request->lawyer_id,
            ]);
            $case = CaseModel::find($request->case_id);
            if ($case) {
            
    // Assuming you want to set the case status to "Scheduled" when a hearing is added
                $case->case_status = "Assigned"; // Change this as needed
                $case->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'Case assigned successfully!',
                'data' => $caseLawyer
            ]);
        } catch (\Exception $e) {

            Log::error('Error assigning case: ' . $e->getMessage(), [
                'case_id' => $request->case_id,
                'lawyer_id' => $request->lawyer_id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function checkCase(Request $request)
    {
        try {
            $case_number = trim($request->case_number); // Trim spaces
    
            // Find the case in the database
            $case = CaseModel::whereRaw('LOWER(case_number) = ?', [strtolower($case_number)])->first();
    
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
                'case_number' => $case->case_number,
                'matter' => null
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate case details
            $caseData = $request->validate([
                'track_number' =>  'required|string|max:255|unique:cases,track_number',
                'case_number'      => 'required|string|max:255|unique:cases,case_number',
                'case_name'        => 'required|string|max:255',
                'date_received' => 'required|date_format:Y-m-d\TH:i',
                'case_description' => 'required|string',
                'case_status'      => 'required|string|max:255',
                'case_category'    => 'required|in:Academic,Disciplinary,Administrative,student,staff,supplier,staff union',
                'initial_status'   => 'required|in:Under Review,Approved,Rejected,Needs Negotiation',
                
            ]);

            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->date_received);

    
            $caseData['created_by'] = Auth::id();
            $caseData['date_received'] = $dateTime->toDateString();
            $caseData['time_received'] = $dateTime->toTimeString();
            // Validate complainant details
            $complainantData = $request->validate([
                'complainant_name' => 'required|string|max:255',
                'phone'            => 'nullable|string|max:255',
                'email'            => 'nullable|email|max:255',
                'address'          => 'nullable|string|max:255',
            ]);
    
            // Validate document uploads (only if files exist)
            if ($request->hasFile('documents')) {
                $documentData = $request->validate([
                    'documents.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048',
                ]);
            }
    
            // Create the case first
            $case = CaseModel::create($caseData);
    
            // Assign case_id to complainant and save
            $complainantData['case_id'] = $case->case_id;
            Complainant::create($complainantData);
    
            // Save documents if they exist
           // Check if the request contains the 'documents' files array
                    if ($request->hasFile('documents')) {
                        foreach ($request->file('documents') as $document) {
                            $fileName = time() . '_' . $document->getClientOriginalName(); // Unique file name
                            $filePath = $document->storeAs('public/documents', $fileName); // Store file in storage/app/public/documents
                    
                            // Save document details in the database
                            CaseDocument::create([
                                'case_id' => $case->case_id,
                                'document_name' => $fileName, // Store only the filename, not the path
                            ]);
                        }
                    }


                //Sending to lawyers and admins

                    // Safely get recipients with case-insensitive check
                    $totalRecipients = 0;

                    User::whereIn('role', ['Admin'])
                        ->whereNotNull('email')
                        ->chunkById(200, function ($users) use ($case, &$totalRecipients) {
                            $totalRecipients += $users->count();
                            
                            foreach ($users as $user) {
                                try {
                                    
                                        $isReminder = false;
                                        // Mail::to('intern-ict@ku.ac.ke')->send(new \App\Mail\TestEmail(['name' => 'Isaiah']));
                                        Mail::to($user->email)->queue(new CaseNotification($case, $isReminder));
                                    
                                    Log::debug('Queued case notification', [
                                        'user_id' => $user->user_id,
                                        'case_id' => $case->case_id
                                    ]);
                                } catch (\Throwable $e) {
                                    Log::error('Failed to queue case notification', [
                                        'user_id' => $user->user_id,
                                        'error' => $e->getMessage()
                                    ]);
                                }
                            }
                        });
                    
                    Log::info('Queued case notifications for {count} recipients', [
                        'count' => $totalRecipients,
                        'case_id' => $case->case_id
                    ]);
        return redirect()->route('cases.show', $case) ->with('success', 'Case Registered Successfully!');

          //  return redirect()->route('cases.index')->with('success', 'Case Created Successfully!');
        } catch (\Exception $e) {
            Log::error('Error is: '. $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    

    /**
     * Display the specified resource.
     */
    
     public function show(CaseModel $case)
     {

        
        if (Str::contains($case->case_status, '-')) {
            $parts = explode('-', $case->case_status);
           
            // add two new attributes:
          
            if (count($parts) == 2 && is_numeric($parts[0])) {
                

                $ordinal =$this->ordinalParts((int) $parts[0]);
                $case->seq_num = $ordinal['number'];
               $case->seq_suffix = $ordinal['suffix'];
               $case->matter = $parts[1];

            } else {
                $case->case_status_formatted = $case->case_status;
            }
        } else {
            $case->case_status_formatted = $case->case_status;
        }
     $complainant = Complainant::where('case_id', $case->case_id)->first();

        
      $caseDocuments = CaseDocument::where('case_id', $case->case_id)->get();
       return view('cases.view', compact('case', 'complainant', 'caseDocuments'));

     }
     
    /**
     * Show the form for editing the specified resource.
     */
   /*
     public function edit(string $case_id)
    {
        //

        $case = CaseModel::where('case_id', $case_id)->firstOrFail(); // Use the correct primary key

        return view('cases.edit', compact('case'));
    }
    */

  public function edit(CaseModel $case)
  {
      // Retrieve the complainant related to the case
      $complainant = Complainant::where('case_id', $case->case_id)->first();
  
      // Retrieve all case documents related to the case
      $caseDocuments = CaseDocument::where('case_id', $case->case_id)->get();
  
      return view('cases.edit', compact('case', 'complainant', 'caseDocuments'));
  }
  


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $case_id)
{
    try {
        Log::info("Updating case with ID: " . $case_id);

        // Validate input
        $validatedData = $request->validate([
            'case_number'       => 'required|string|max:255',
            'case_name'         => 'required|string|max:255',
            'case_description'  => 'nullable|string',
            'date_received'     => 'required|date',
            'case_category'     => 'required|string',
            'case_status'       => 'required|string',
            'initial_status'    => 'required|string',
        ]);

        // Find case and update
        $case = CaseModel::where('case_id', $case_id)->firstOrFail();
        Log::info("Found case:", $case->toArray());
        $case->update($validatedData);

        Log::info("Updated case:", $case->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Case updated successfully!',
            'case'    => $case
        ]);
    } catch (\Exception $e) {
        Log::error("Error updating case: " . $e->getMessage());
        return response()->json(['error' => 'Failed to update case: ' . $e->getMessage()], 500);
    }
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

  

    public function destroyDocument($document_id)
{
    Log::info("Received request to delete document with ID: " . $document_id);

    $document = CaseDocument::where('document_id', $document_id)->first();
    
    if (!$document) {
        Log::error("Document not found with ID: " . $document_id);
        return response()->json(['error' => 'Document not found'], 404);
    }

    // Delete the actual file from storage
    $deleted = Storage::delete('documents/' . $document->document_name);

    if (!$deleted) {
        Log::error("Failed to delete file: " . $document->document_name);
    }

    // Delete the record from the database
    $document->delete();

    Log::info("Document deleted successfully: " . $document->document_name);

    return response()->json(['message' => 'Document deleted successfully'], 200);
}



public function getAssignedLawyers($caseId)
{
    $lawyers = CaseLawyer::where('case_id', $caseId)
        ->with(['lawyer.user']) // Ensure user relationship is loaded
        ->get()
        ->map(function ($lawyer) {
            return [
                'lawyer_id' => $lawyer->lawyer->lawyer_id,
                'license_number' => $lawyer->lawyer->license_number,
                'full_name' => $lawyer->lawyer->user->full_name,
            ];
        });

    return response()->json($lawyers);
}

public function removeAssignedLawyer($case_id, $lawyer_id)
{
    CaseLawyer::where('case_id', $case_id)->where('lawyer_id', $lawyer_id)->delete();
    return response()->json(['success' => true]);
}


public function getLawyers(Request $request)
{
    $caseId = $request->input('case_id');

    if (!$caseId) {
        Log::info("The case id: ".$caseId);
        return response()->json(['error' => 'Case ID is required'], 400);
    }

    $lawyers = Lawyer::with('user')
        ->whereNotIn('lawyer_id', function ($query) use ($caseId) {
            $query->select('lawyer_id')->from('case_lawyer')->where('case_id', $caseId);
        })
        ->get()
        ->map(function ($lawyer) {
            return [
                'lawyer_id' => $lawyer->lawyer_id,
                'display_name' => $lawyer->user->full_name . ' - ' . $lawyer->license_number
            ];
        });

    Log::info("Available Lawyers: ", $lawyers->toArray());

    return response()->json($lawyers);
}


public function getLastSequence($case_id)
{
    try {
        // Get the last sequence number for hearings for the given case_id
        $lastSequence = \App\Models\CaseActivity::where('case_id', $case_id)
            ->where('type', 'hearing')
            ->max('sequence_number');

        // Set the next sequence number
        $nextSequence = $lastSequence ? $lastSequence + 1 : 1; // Default to 1 if no previous hearings

        // Generate the next sequence with ordinal suffix
        $nextSequenceText = $this->getOrdinal($nextSequence) . ' Hearing';

        // Return the next sequence data as JSON
        return response()->json(['nextSequence' => $nextSequence, 'nextSequenceText' => $nextSequenceText]);

    } catch (\Exception $e) {
        Log::error('Error', [$e->getMessage()]);
        return response()->json(['error' => $e->getMessage()]);
    }
}

// Helper function to get ordinal suffixes
public function getOrdinal($number)
{
    // Special case for 11th, 12th, 13th, etc.
    if ($number % 100 >= 11 && $number % 100 <= 13) {
        return $number . 'th';
    }

    // Otherwise, handle the last digit
    switch ($number % 10) {
        case 1:
            return $number . 'st';
        case 2:
            return $number . 'nd';
        case 3:
            return $number . 'rd';
        default:
            return $number . 'th';
    }
}




public function addHearing(Request $request)


{



    Log::info("The sequence number is: ".$request->sequence_number);
    try {
        $validated = $request->validate([
            'case_id' => 'required|integer|exists:cases,case_id',
            'sequence_number' => 'required|integer|min:1',
            'court_room_number' => 'required|string|max:255',
            'court_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'hearing_type' => 'required|in:virtual,physical',
            'virtual_link' => 'nullable|string|max:500',
            'court_contacts' => 'nullable|string',
        ]);

        CaseActivity::create([
            'case_id' => $validated['case_id'],
            'type' => 'hearing',
            'sequence_number' => $validated['sequence_number'],
            'court_room_number' => $validated['court_room_number'],
            'court_name' => $validated['court_name'],
            'time' => $validated['time'],
            'date' => $validated['date'],
            'hearing_type' => $validated['hearing_type'],
            'virtual_link' => $validated['virtual_link'] ?? null,
            'court_contacts' => $validated['court_contacts'] ?? null,
        ]);

         // Update the case status after adding the hearing
         $case = CaseModel::find($validated['case_id']);
         if ($case) {
           
  // Assuming you want to set the case status to "Scheduled" when a hearing is added
             $case->case_status = $validated['sequence_number'].'-Hearing'; // Change this as needed
             $case->save();
         }
 
        return response()->json(['message' => 'Hearing added successfully.']);

    } catch (\Exception $e) {
        Log::error('Add hearing error', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to add hearing.'], 500);
    }
}


public function addMention(Request $request)


{



    Log::info("The sequence number is: ".$request->sequence_number);
    try {
        $validated = $request->validate([
            'case_id' => 'required|integer|exists:cases,case_id',
            'sequence_number' => 'required|integer|min:1',
            'court_room_number' => 'required|string|max:255',
            'court_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'hearing_type' => 'required|in:virtual,physical',
            'virtual_link' => 'nullable|string|max:500',
            'court_contacts' => 'nullable|string',
        ]);

        CaseActivity::create([
            'case_id' => $validated['case_id'],
            'type' => 'mention',
            'sequence_number' => $validated['sequence_number'],
            'court_room_number' => $validated['court_room_number'],
            'court_name' => $validated['court_name'],
            'time' => $validated['time'],
            'date' => $validated['date'],
            'hearing_type' => $validated['hearing_type'],
            'virtual_link' => $validated['virtual_link'] ?? null,
            'court_contacts' => $validated['court_contacts'] ?? null,
        ]);
        $case = CaseModel::find($validated['case_id']);
         if ($case) {
             // Assuming you want to set the case status to "Scheduled" when a hearing is added
             $case->case_status = $validated['sequence_number'].'-Mention'; // Change this as needed
             $case->save();
         }
 
        return response()->json(['message' => 'Mention added successfully.']);

    } catch (\Exception $e) {
        Log::error('Add Mention error', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to add Mention.'], 500);
    }
}

public function addApplication(Request $request)

{



    Log::info("The sequence number is: ".$request->sequence_number);
    try {
        $validated = $request->validate([
            'case_id' => 'required|integer|exists:cases,case_id',
            'sequence_number' => 'required|integer|min:1',
            'court_room_number' => 'required|string|max:255',
            'court_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'hearing_type' => 'required|in:virtual,physical',
            'virtual_link' => 'nullable|string|max:500',
            'court_contacts' => 'nullable|string',
        ]);

        CaseActivity::create([
            'case_id' => $validated['case_id'],
            'type' => 'application',
            'sequence_number' => $validated['sequence_number'],
            'court_room_number' => $validated['court_room_number'],
            'court_name' => $validated['court_name'],
            'time' => $validated['time'],
            'date' => $validated['date'],
            'hearing_type' => $validated['hearing_type'],
            'virtual_link' => $validated['virtual_link'] ?? null,
            'court_contacts' => $validated['court_contacts'] ?? null,
        ]);
        $case = CaseModel::find($validated['case_id']);
         if ($case) {
             // Assuming you want to set the case status to "Scheduled" when a hearing is added
             $case->case_status = $validated['sequence_number'].'-Application'; // Change this as needed
             $case->save();
         }
 

        return response()->json(['message' => 'Application added successfully.']);

    } catch (\Exception $e) {
        Log::error('Add Application error', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to add Application.'], 500);
    }
}

public function getLastSequenceMention($case_id)
{
    try {
        // Get the last sequence number for hearings for the given case_id
        $lastSequence = \App\Models\CaseActivity::where('case_id', $case_id)
            ->where('type', 'mention')
            ->max('sequence_number');

        // Set the next sequence number
        $nextSequence = $lastSequence ? $lastSequence + 1 : 1; // Default to 1 if no previous hearings

        // Generate the next sequence with ordinal suffix
        $nextSequenceText = $this->getOrdinal($nextSequence) . ' Mention';

        // Return the next sequence data as JSON
        return response()->json(['nextSequence' => $nextSequence, 'nextSequenceText' => $nextSequenceText]);

    } catch (\Exception $e) {
        Log::error('Error', [$e->getMessage()]);
        return response()->json(['error' => $e->getMessage()]);
    }
}

public function getLastSequenceApplication($case_id)
{
    try {
        // Get the last sequence number for hearings for the given case_id
        $lastSequence = \App\Models\CaseActivity::where('case_id', $case_id)
            ->where('type', 'application')
            ->max('sequence_number');

        // Set the next sequence number
        $nextSequence = $lastSequence ? $lastSequence + 1 : 1; // Default to 1 if no previous hearings

        // Generate the next sequence with ordinal suffix
        $nextSequenceText = $this->getOrdinal($nextSequence) . ' Application';

        // Return the next sequence data as JSON
        return response()->json(['nextSequence' => $nextSequence, 'nextSequenceText' => $nextSequenceText]);

    } catch (\Exception $e) {
        Log::error('Error', [$e->getMessage()]);
        return response()->json(['error' => $e->getMessage()]);
    }
}




public function showUpdateForm(Request $request)
{
    

    try{
   $caseId = $request->input('case_id');
    $caseName = $request->input('case_name');
    $type = $request->input('type'); // should be 'hearing'


    Log::info("Type: ".$type. " Case Name: ".$caseName." Case ID: ". $caseId);

    $activities = CaseActivity::where('case_id', $caseId)
                    ->where('type', $type)
                    ->get();

    Log::info("Activities are: ", $activities->toArray());
   // Instead of returning a view, send the redirect URL
   $redirectUrl = route('cases.matter', ['case_id' => $caseId, 'case_name' => $caseName, 'activities'=> $activities,'type' => $type]);

   return response()->json(['redirect_url' => $redirectUrl]);

    }
    catch(\Exception $e){
        Log::error('', [$e->getMessage()]);
        return response()->json(['error'=> $e->getMessage()]);
    }
}

private function ordinalParts(int $number): array
{
    $abs = abs($number);
    $mod100 = $abs % 100;
    if ($mod100 >= 11 && $mod100 <= 13) {
        $suffix = 'th';
    } else {
        switch ($abs % 10) {
            case 1:  $suffix = 'st'; break;
            case 2:  $suffix = 'nd'; break;
            case 3:  $suffix = 'rd'; break;
            default: $suffix = 'th';
        }
    }
    return [
        'number' => $number,
        'suffix' => $suffix,
    ];
}


public function showMatter(Request $request)
{
    try {
        // Retrieve parameters from the URL
        $caseId = $request->input('case_id');
        $caseName = $request->input('case_name');
        $type = $request->input('type'); // Get the type (hearing, mention, application)

        // If case_id is not provided, fetch all activities
        if (!$caseId) {
            // Fetch all activities across all cases
            $activities = CaseActivity::all();
        } else {
            // If case_id is provided, filter by case_id and optionally by type
            if (!$type) {
                // If no type is provided, fetch all activities for the specific case_id
                $activities = CaseActivity::where('case_id', $caseId)->get();
            } else {
                // If type is provided, filter by both case_id and type
                $activities = CaseActivity::where('case_id', $caseId)
                    ->where('type', $type)
                    ->get();
            }
        }

        // Apply ordinal suffix to sequence_number
        // after you’ve loaded $activities…
        $activities = $activities->map(function($activity) {
            $parts = $this->ordinalParts($activity->sequence_number);
            // add two new attributes:
            $activity->seq_num = $parts['number'];
            $activity->seq_suffix = $parts['suffix'];

                    // date & time formatting
        $activity->formatted_date = Carbon::parse($activity->date)
        ->format('M d, Y');
        $activity->formatted_time = Carbon::parse($activity->time)
        ->format('h:i A');

            return $activity;
        });


        Log::info("Activities for Case ID: $caseId are: ", $activities->toArray());

        // Return the view and pass the necessary data
        return view('cases.update-matter', [
            'case_id' => $caseId,
            'case_name' => $caseName,
            'activities' => $activities
        ]);
    } catch (\Exception $e) {
        Log::error('Error occurred: ', [$e->getMessage()]);
        return response()->json(['error' => $e->getMessage()]);
    }
}



public function ActivityShow($id)
    {
        // Attempt to find the activity
        $activity = CaseActivity::find($id);
        

        if (! $activity) {
            return response()->json([
                'error' => 'CaseActivity not found.'
            ], 404);
        }

        $case_name = $activity->case->case_name;
        $case_number = $activity->case->case_number;



        $parts = $this->ordinalParts($activity->sequence_number);
            // add two new attributes:
        $activity->seq_num = $parts['number'];
        $activity->seq_suffix = $parts['suffix'];

                    // date & time formatting
        $activity->formatted_date = Carbon::parse($activity->date)
        ->format('M d, Y');
        $activity->formatted_time = Carbon::parse($activity->time)
        ->format('h:i A');

        // Return the activity as JSON
        return response()->json([
            'data' => $activity,
             'case_name' => $case_name,
             'case_number' => $case_number

        ]);
    }


    public function updateMatter(Request $request)
    {
        Log::info("Updating CaseActivity ID: " . $request->id);

        $validated = $request->validate([
            'id'                 => 'required|integer|exists:case_activities,id',
            'case_id'            => 'required|integer|exists:cases,case_id',
            'sequence_number'    => 'required|integer|min:1',
            'court_room_number'  => 'required|string|max:255',
            'court_name'         => 'required|string|max:255',
            'date'               => 'required|date',
            'time'               => 'required',
            'hearing_type'       => 'required|in:virtual,physical',
            'virtual_link'       => 'nullable|string|max:500',
            'court_contacts'     => 'nullable|string',
            'type'               => 'required|string|in:hearing,mention,application',
        ]);

        try {
            $activity = CaseActivity::findOrFail($validated['id']);

            // Update only the allowed fields
            $activity->update([
                'case_id'           => $validated['case_id'],
                'type'              => $validated['type'],
                'sequence_number'   => $validated['sequence_number'],
                'court_room_number' => $validated['court_room_number'],
                'court_name'        => $validated['court_name'],
                'date'              => $validated['date'],
                'time'              => $validated['time'],
                'hearing_type'      => $validated['hearing_type'],
                'virtual_link'      => $validated['virtual_link'] ?? null,
                'court_contacts'    => $validated['court_contacts'] ?? null,
            ]);

            return response()->json(['message' => 'Activity updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Update activity error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update activity.'], 500);
        }
    }


    public function destroyActivity($id)
{
    try {
        $activity = CaseActivity::findOrFail($id);
        $activity->delete();

        return response()->json(['message' => 'Activity deleted successfully.']);
    } catch (\Exception $e) {
        Log::error("Delete error", ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to delete activity.'], 500);
    }
}

    



public function getLastSequenceAll(Request $request, $case_id)
{
    try {
        $type = $request->query('type');

        if (!$type) {
            return response()->json(['error' => 'Type parameter is required.'], 400);
        }

        $lastSequence = CaseActivity::where('case_id', $case_id)
            ->where('type', $type)
            ->max('sequence_number');

        $nextSequence = $lastSequence ? $lastSequence + 1 : 1;
        $nextSequenceText = $this->getOrdinal($nextSequence) . ' ' . ucfirst($type);

        return response()->json([
            'nextSequence' => $nextSequence,
            'nextSequenceText' => $nextSequenceText
        ]);

    } catch (\Exception $e) {
        Log::error('Error fetching sequence', [$e->getMessage()]);
        return response()->json(['error' => 'Failed to retrieve sequence.'], 500);
    }
}





public function addActivity(Request $request)

{



    Log::info("The sequence number is: ".$request->sequence_number);
    try {
        $validated = $request->validate([
            'case_id' => 'required|integer|exists:cases,case_id',
            'type' => 'required|string|max:255',
            'sequence_number' => 'required|string|min:1',
            'court_room_number' => 'required|string|max:255',
            'court_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'hearing_type' => 'required|in:virtual,physical',
            'virtual_link' => 'nullable|string|max:500',
            'court_contacts' => 'nullable|string',
        ]);

        CaseActivity::create([
            'case_id' => $validated['case_id'],
            'type' => $validated['type'],
            'sequence_number' => $validated['sequence_number'],
            'court_room_number' => $validated['court_room_number'],
            'court_name' => $validated['court_name'],
            'time' => $validated['time'],
            'date' => $validated['date'],
            'hearing_type' => $validated['hearing_type'],
            'virtual_link' => $validated['virtual_link'] ?? null,
            'court_contacts' => $validated['court_contacts'] ?? null,
        ]);

        return response()->json(['message' => 'Activity added successfully.']);

    } catch (\Exception $e) {
        Log::error('Add Application error', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to add Activity.'], 500);
    }
}



private function getTypeColor($type)
{
    return match (strtolower($type)) {
        'hearing' => '#007bff',
        'mention' => '#28a745',
        'application' => '#ffc107',
        default => '#6c757d',
    };
}





public function sendEmail($case_id)
{
    try {
      /*
        $case = CaseModel::where('case_id', $case_id)->firstOrFail();
        $isReminder = false; // or true, depending on your logic
        Log::info("Case id is: ".$case->case_id);

        Mail::to('intern-ict@ku.ac.ke')->queue(new CaseNotification($case, $isReminder));

        Log::info('Queued email for case', [$case->case_id]);
        return back()->with('success', 'Email queued successfully.');

        */
        $case = CaseModel::where('case_id', $case_id)->firstOrFail();
        Log::info("The case is: ", $case->toArray());
    $isReminder = false;
    //Mail::to('intern-ict@ku.ac.ke')->send(new \App\Mail\TestEmail(['name' => 'Isaiah']));
    Mail::to('intern-ict@ku.ac.ke')->queue(new CaseNotification($case, $isReminder));

    return back()->with('success', 'Email has been queued. '.$case->case_name);
    } catch (\Exception $e) {
        Log::error('Error sending email:', [$e->getMessage()]);
        return back()->with('error', 'Failed to send email: ' . $e->getMessage());
    }
}




public function getEvents()
{
 
   
    try {
        // Step 1: Get the case_ids for the currently logged-in lawyer
       

        
        $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
        if ($isLawyer) {
            $lawyerId = Auth::user()->lawyer->lawyer_id;
            Log::info('Lawyer id is: '.$lawyerId.' Jaba');

        $caseIds = \App\Models\CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');
     /*
        // Step 2: Get activities where the case_id is in the case_ids retrieved above
        $activities = CaseActivity::whereIn('case_id', $caseIds)->get();
    
        $events = $activities->map(function ($activity) {
            // Get the ordinal parts for the sequence number
            $parts = $this->ordinalParts($activity->sequence_number);
            $activity->seq_num = $parts['number'];
            $activity->seq_suffix = $parts['suffix'];

            // Format the title and content
            $title = $this->getOrdinal($activity->sequence_number) . ' ' . ucfirst($activity->type);
            $titleContent = $activity->seq_num . '<sup>' . $activity->seq_suffix . '</sup>' . ' ' . ucfirst($activity->type);

            return [
                'id' => $activity->id,
                'title' => $title,
                'titleContent' => $titleContent,
                'start' => $activity->date->format('Y-m-d') . 'T' . $activity->time, // Combine date and time
                'allDay' => false, // Set true if it's a full-day event
                'color' => $this->getTypeColor($activity->type),
            ];
        });

        return response()->json($events);
     */
             

            //Negotiations
            $activities_negotiate = $activities_negotiate = Negotiation::whereIn('case_id', $caseIds)->get();

            $events_negotiate = $activities_negotiate ->map(function ($activity_negotiate) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Negotiation" ;
                $titleContent = $activity_negotiate ->	outcome	;
    
                return [
                    'id' =>$activity_negotiate->negotiation_id . '.negotiate',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => $activity_negotiate->initiation_datetime,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => 'rgb(6, 53, 80)',
                    


                ];
            });


            //Lawyer Payments
             //Law Payments
             $activities_lawyer= $activities_lawyerpay = LawyerPayment::whereIn('case_id', $caseIds)->get();

             $events_lawyerpay= $activities_lawyerpay->map(function ($activity_lawyerpay) {
                 // Get the ordinal parts for the sequence number
                 
                 // Format the title and content
                 $title = " Lawyer Payment" ;
                 $titleContent = $activity_lawyerpay->	transaction	;
     
                 return [
                     'id' => $activity_lawyerpay->payment_id . '.lawyerpayment',
                     'title' => $title,
                     'titleContent' => $titleContent,
                     'start' => \Carbon\Carbon::parse($activity_lawyerpay->payment_date)->format('Y-m-d') . 'T' . $activity_lawyerpay->payment_time,
                     'allDay' => false, // Set true if it's a full-day event
                     'color' => 'rgb(14, 168, 22)',
                     
 
 
                 ];
             });
 

            //Law Payments
            $activities_all= $activities_all = Payment::whereIn('case_id', $caseIds)->get();

            $events_all= $activities_all->map(function ($activity_all) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Payment" ;
                $titleContent = $activity_all->	transaction	;
    
                return [
                    'id' => $activity_all->payment_id . '.allpayment',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_all->payment_date)->format('Y-m-d') . 'T' . $activity_all->payment_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => 'rgb(194, 15, 218)',
                    


                ];
            });


            // AG Advice
            $activities_advice= $activities_advice = AGAdvice::whereIn('case_id', $caseIds)->get();

            $events_advice= $activities_advice->map(function ($activity_advice) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " AG Advice" ;
                $titleContent = $activity_advice->	ag_advice	;
    
                return [
                    'id' => $activity_advice->ag_advice_id . '.advice',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_advice->advice_date)->format('Y-m-d') . 'T' . $activity_advice->	advice_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => ' #272838',
                    


                ];
            });


            //Appointment
            
            $activities_appointment = $activities_appointment = Forwarding::whereIn('case_id', $caseIds)->get();

            $events_appointment = $activities_appointment->map(function ($activity_appointment) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Appointment" ;
                $titleContent = $activity_appointment->briefing_notes	;
    
                return [
                    'id' => $activity_appointment->forwarding_id . '.appointment',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_appointment->dvc_appointment_date)->format('Y-m-d') . 'T' . $activity_appointment->dvc_appointment_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#F2B418',
                    


                ];
            });



            //Trial
            $activities_trial = $activities_trial = Trial::whereIn('case_id', $caseIds)->get();

            $events_trial = $activities_trial->map(function ($activity_trial) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Trial" ;
                $titleContent = $activity_trial->judgement_details	;
    
                return [
                    'id' => $activity_trial->trial_id. '.trial',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_trial->trial_date)->format('Y-m-d') . 'T' . $activity_trial->trial_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#AFCBD5',
                    


                ];
            });




            //Trial Preparation Events
            $activities_preparation = $activities_preparation = TrialPreparation::whereIn('case_id', $caseIds)->get();

            $events_preparation = $activities_preparation->map(function ($activity_preparation) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Preparation" ;
                $titleContent = $activity_preparation->briefing_notes;
    
                return [
                    'id' => $activity_preparation->preparation_id. '.preparation',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_preparation->preparation_date)->format('Y-m-d') . 'T' . $activity_preparation->preparation_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#445D48',
                    


                ];
            });


            //Adjourn Events

            $activities_adjourn = $activities_adjourn = Adjourn::whereIn('case_id', $caseIds)->get();

            $events_adjourn = $activities_adjourn->map(function ($activity_adjourn) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Adjourn" ;
                $titleContent = $activity_adjourn->adjourn_comments;
    
                return [
                    'id' => $activity_adjourn->adjourns_id. '.adjourn',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_adjourn->next_hearing_date)->format('Y-m-d') . 'T' . $activity_adjourn->next_hearing_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#F57251',
                    


                ];
            });



            //Appeal Events
             $activities_appeal = $activities_appeal = Appeal::whereIn('case_id', $caseIds)->get();

            $events_appeal = $activities_appeal->map(function ($activity_appeal) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Appeal" ;
                $titleContent = $activity_appeal->appeal_comments;
    
                return [
                    'id' => $activity_appeal->appeal_id. '.appeal',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_appeal->next_hearing_date)->format('Y-m-d') . 'T' . $activity_appeal->next_hearing_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#C4AD9D',
                    
                ];
            });


            $activities = $activities = CaseActivity::whereIn('case_id', $caseIds)->get();

            $events = $activities->map(function ($activity) {
                // Get the ordinal parts for the sequence number
                $parts = $this->ordinalParts($activity->sequence_number);
                $activity->seq_num = $parts['number'];
                $activity->seq_suffix = $parts['suffix'];
    
                // Format the title and content
                $title = $this->getOrdinal($activity->sequence_number) . ' ' . ucfirst($activity->type);
                $titleContent = $activity->seq_num . '<sup>' . $activity->seq_suffix . '</sup>' . ' ' . ucfirst($activity->type);
    
                return [
                    'id' => $activity->id. '.activity',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => $activity->date->format('Y-m-d') . 'T' . $activity->time, // Combine date and time
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => $this->getTypeColor($activity->type),
                    
                ];
            });
    
            $combinedEvents = $events->merge($events_appeal);
            $combinedEvents = $combinedEvents->merge($events_adjourn);
            $combinedEvents = $combinedEvents->merge($events_preparation);
            $combinedEvents = $combinedEvents->merge($events_trial);
            $combinedEvents = $combinedEvents->merge($events_appointment);
            $combinedEvents = $combinedEvents->merge($events_advice);
            $combinedEvents = $combinedEvents->merge($events_all);
            $combinedEvents = $combinedEvents->merge($events_lawyerpay);
            $combinedEvents = $combinedEvents->merge($events_negotiate);
            return response()->json($combinedEvents);

    }
    else{

            //If not a lawyer

            //Negotiations
            $activities_negotiate = $activities_negotiate = Negotiation::all();

            $events_negotiate = $activities_negotiate ->map(function ($activity_negotiate) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Negotiation" ;
                $titleContent = $activity_negotiate ->	outcome	;
    
                return [
                    'id' =>$activity_negotiate->negotiation_id . '.negotiate',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => $activity_negotiate->initiation_datetime,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => 'rgb(6, 53, 80)',
                    


                ];
            });


            //Lawyer Payments
             //Law Payments
             $activities_lawyer= $activities_lawyerpay = LawyerPayment::all();

             $events_lawyerpay= $activities_lawyerpay->map(function ($activity_lawyerpay) {
                 // Get the ordinal parts for the sequence number
                 
                 // Format the title and content
                 $title = " Lawyer Payment" ;
                 $titleContent = $activity_lawyerpay->	transaction	;
     
                 return [
                     'id' => $activity_lawyerpay->payment_id . '.lawyerpayment',
                     'title' => $title,
                     'titleContent' => $titleContent,
                     'start' => \Carbon\Carbon::parse($activity_lawyerpay->payment_date)->format('Y-m-d') . 'T' . $activity_lawyerpay->payment_time,
                     'allDay' => false, // Set true if it's a full-day event
                     'color' => 'rgb(14, 168, 22)',
                     
 
 
                 ];
             });
 

            //Law Payments
            $activities_all= $activities_all = Payment::all();

            $events_all= $activities_all->map(function ($activity_all) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Payment" ;
                $titleContent = $activity_all->	transaction	;
    
                return [
                    'id' => $activity_all->payment_id . '.allpayment',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_all->payment_date)->format('Y-m-d') . 'T' . $activity_all->payment_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => 'rgb(194, 15, 218)',
                    


                ];
            });


            // AG Advice
            $activities_advice= $activities_advice = AGAdvice::all();

            $events_advice= $activities_advice->map(function ($activity_advice) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " AG Advice" ;
                $titleContent = $activity_advice->	ag_advice	;
    
                return [
                    'id' => $activity_advice->ag_advice_id . '.advice',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_advice->advice_date)->format('Y-m-d') . 'T' . $activity_advice->	advice_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => ' #272838',
                    


                ];
            });


            //Appointment
            
            $activities_appointment = $activities_appointment = Forwarding::all();

            $events_appointment = $activities_appointment->map(function ($activity_appointment) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Appointment" ;
                $titleContent = $activity_appointment->briefing_notes	;
    
                return [
                    'id' => $activity_appointment->forwarding_id . '.appointment',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_appointment->dvc_appointment_date)->format('Y-m-d') . 'T' . $activity_appointment->dvc_appointment_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#F2B418',
                    


                ];
            });



            //Trial
            $activities_trial = $activities_trial = Trial::all();

            $events_trial = $activities_trial->map(function ($activity_trial) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Trial" ;
                $titleContent = $activity_trial->judgement_details	;
    
                return [
                    'id' => $activity_trial->trial_id. '.trial',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_trial->trial_date)->format('Y-m-d') . 'T' . $activity_trial->trial_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#AFCBD5',
                    


                ];
            });




            //Trial Preparation Events
            $activities_preparation = $activities_preparation = TrialPreparation::all();

            $events_preparation = $activities_preparation->map(function ($activity_preparation) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Preparation" ;
                $titleContent = $activity_preparation->briefing_notes;
    
                return [
                    'id' => $activity_preparation->preparation_id. '.preparation',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_preparation->preparation_date)->format('Y-m-d') . 'T' . $activity_preparation->preparation_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#445D48',
                    


                ];
            });


            //Adjourn Events

            $activities_adjourn = $activities_adjourn = Adjourn::all();

            $events_adjourn = $activities_adjourn->map(function ($activity_adjourn) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Adjourn" ;
                $titleContent = $activity_adjourn->adjourn_comments;
    
                return [
                    'id' => $activity_adjourn->adjourns_id. '.adjourn',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_adjourn->next_hearing_date)->format('Y-m-d') . 'T' . $activity_adjourn->next_hearing_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#F57251',
                    


                ];
            });



            //Appeal Events
             $activities_appeal = $activities_appeal = Appeal::all();

            $events_appeal = $activities_appeal->map(function ($activity_appeal) {
                // Get the ordinal parts for the sequence number
                
                // Format the title and content
                $title = " Appeal" ;
                $titleContent = $activity_appeal->appeal_comments;
    
                return [
                    'id' => $activity_appeal->appeal_id. '.appeal',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => \Carbon\Carbon::parse($activity_appeal->next_hearing_date)->format('Y-m-d') . 'T' . $activity_appeal->next_hearing_time,
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => '#C4AD9D',
                    
                ];
            });


            $activities = $activities = CaseActivity::all();

            $events = $activities->map(function ($activity) {
                // Get the ordinal parts for the sequence number
                $parts = $this->ordinalParts($activity->sequence_number);
                $activity->seq_num = $parts['number'];
                $activity->seq_suffix = $parts['suffix'];
    
                // Format the title and content
                $title = $this->getOrdinal($activity->sequence_number) . ' ' . ucfirst($activity->type);
                $titleContent = $activity->seq_num . '<sup>' . $activity->seq_suffix . '</sup>' . ' ' . ucfirst($activity->type);
    
                return [
                    'id' => $activity->id. '.activity',
                    'title' => $title,
                    'titleContent' => $titleContent,
                    'start' => $activity->date->format('Y-m-d') . 'T' . $activity->time, // Combine date and time
                    'allDay' => false, // Set true if it's a full-day event
                    'color' => $this->getTypeColor($activity->type),
                    
                ];
            });
    
            $combinedEvents = $events->merge($events_appeal);
            $combinedEvents = $combinedEvents->merge($events_adjourn);
            $combinedEvents = $combinedEvents->merge($events_preparation);
            $combinedEvents = $combinedEvents->merge($events_trial);
            $combinedEvents = $combinedEvents->merge($events_appointment);
            $combinedEvents = $combinedEvents->merge($events_advice);
            $combinedEvents = $combinedEvents->merge($events_all);
            $combinedEvents = $combinedEvents->merge($events_lawyerpay);
            $combinedEvents = $combinedEvents->merge($events_negotiate);
            return response()->json($combinedEvents);

        }
    } catch (\Exception $e) {
        Log::error('Calendar event fetch failed', [$e->getMessage()]);
        return response()->json(['error' => 'Could not fetch events.'], 500);
    }
}

public function submitToPanelEvaluation(Request $request, $case_id)
{
   
   try{
    $case = CaseModel::findOrFail($case_id);
    $message = $request->input('message'); // 👈 capture the message

    $totalRecipients = 0;
    Log::info("The message is: ". $message);
    User::whereIn('role', ['Lawyer'])
        ->whereNotNull('email')
        ->chunkById(200, function ($users) use ($case, $message, &$totalRecipients) {
            $totalRecipients += $users->count();

            foreach ($users as $user) {
                try {
                    $isReminder = false;
                    Mail::to($user->email)->queue(new CaseNotification($case, $isReminder, $message));

                    Log::debug('Queued case notification', [
                        'user_id' => $user->user_id,
                        'case_id' => $case->case_id
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Failed to queue case notification', [
                        'user_id' => $user->user_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        });

    return response()->json([

        'message' => "Notification queued to {$totalRecipients} lawyers."
    ]);
   }
   catch (\Throwable $e) {

    Log::error("Error", [$e->getMessage()]);
    return response()->json(["Error while sending to panel"]);
   }
    
}



public function showPanelEvaluation($case_id)
{
    $case = CaseModel::findOrFail($case_id); // adjust model name if different
    return view('evaluations.panel-evaluation', ['caseId' => $case->case_id, 'case' => $case]);
}

}

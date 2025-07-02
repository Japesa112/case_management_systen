<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Witness;
use Illuminate\Support\Facades\Log;
use App\Models\WitnessAttachment;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseLawyer;
use Illuminate\Support\Facades\Auth;
class WitnessController extends Controller
{
    // Display list of witnesses

    public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller

         $user = Auth::user();

  


    }

 public function index()
{
    $user = Auth::user();

    // If the user is a lawyer, restrict witnesses to their assigned cases
    if ($user->role === 'Lawyer') {
        $lawyerId = $user->lawyer->lawyer_id ?? null;

        // Get all case_ids assigned to this lawyer
        $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)
            ->pluck('case_id');

        // Get witnesses related to those cases only
        $witnesses = Witness::with('attachments')
            ->whereIn('case_id', $caseIds)
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        // For non-lawyers, show all witnesses
        $witnesses = Witness::with('attachments')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return view('witnesses.index', compact('witnesses'));
}



    // Show form to create a new witness
    public function create($case_id) {
        $case_name = null;
        $witness = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('witnesses.create', compact('case_id', 'case_name', 'witness'));
    }
    

    // Store new witness
    public function store(Request $request)
{
    try {
        // Validate witness data
        $validatedData = $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'witness_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:200',
            'email' => 'nullable|email|max:200',
            'availability' => 'required|in:Yes,No',
            'witness_statement' => 'nullable|string',
            'modalAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
        ]);

        Log::info('Witness Request Data:', $request->all());

        // Create the witness record
        $witness = Witness::create([
            'case_id' => $request->case_id,
            'witness_name' => $request->witness_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'availability' => $request->availability,
            'witness_statement' => $request->witness_statement,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Log::info('Witness Created:', $witness->toArray());

        // Handle file uploads
        if ($request->hasFile('modalAttachments')) {
            foreach ($request->file('modalAttachments') as $file) {
                
           $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                Log::info("time is: ".time());

                $file->storeAs('public/witness_attachments', $uniqueFileName);


                WitnessAttachment::create([
                    'witness_id' => $witness->witness_id,
                      'file_name' => $uniqueFileName, 
                        // Store the original name separately for user-friendly display.
                            // NOTE: This requires adding an 'original_name' column to your table.
                    'file_path' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'upload_date' => now(),
                ]);
            }
        }

        return redirect()->route('witnesses.index', [
            'case_id' => $request->case_id,
            'witness' => $witness->witness_id
        ])->with('witness_success', true)
          ->with('success', 'Witness added successfully.');

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    // Show details of a specific witness
    public function show($witness_id)
    {
        $witness = Witness::with('attachments')->where('witness_id', $witness_id)->firstOrFail();
    
        return response()->json([
            'case_name' => $witness->case->case_name,
            'witness' => $witness,
            'attachments' => $witness->attachments,
        ]);
    }

    // Show form to edit a witness
    public function edit(Witness $witness)
    {
        return view('witnesses.edit', compact('witness'));
    }

    // Update witness details
    // Update witness details
public function update(Request $request, Witness $witness)
{
    Log::info('Received Data:', $request->all());

    try {
        $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'witness_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'availability' => 'required|in:Yes,No',
            'witness_statement' => 'nullable|string',
           
        ]);

        // Update all necessary witness fields
        $witness->update([
            'case_id' => $request->case_id,
            'witness_name' => $request->witness_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'availability' => $request->availability,
            'witness_statement' => $request->witness_statement
            
            
        ]);

        return response()->json(['message' => 'Witness updated successfully.']);
    } catch (\Exception $e) {
        Log::error("The update is not working");
        Log::error($e->getMessage());
        return response()->json(['error' => 'Failed to Update Witness: ' . $e->getMessage()], 500);
    }
}

    

    // Delete witness
    public function destroy(Witness $witness)
    {
        $witness->delete();

        return redirect()->route('witnesses.index')->with('success', 'Witness deleted successfully.');
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
                'witness' => null
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
        $document = WitnessAttachment::where('attachment_id', $documentId)->firstOrFail();

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
        'witness_id' => 'required|exists:witnesses,witness_id',
        'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
      

           $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                Log::info("time is: ".time());

                $file->storeAs('public/witness_attachments', $uniqueFileName);


        $document = WitnessAttachment::create([
            'witness_id' => $request->witness_id,
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

public function getWitnesses()
{
    $witnesses = Witness::all()->map(function ($witness) {
        return [
            'witness_id' => $witness->witness_id,
            'display_name' => $witness->witness_name . ' (' . $witness->phone . ')',
        ];
    });

    return response()->json($witnesses);
}


    
}

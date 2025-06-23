<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreTrial;
use App\Models\PreTrialMember;
use App\Models\PreTrialAttachment;
use App\Models\CaseModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseLawyer;
class PreTrialController extends Controller
{
    

    
    public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
    }
    // Show all pre-trials
  public function index($case_id)
        {
            $preTrials = PreTrial::with(['members', 'attachments'])
                ->where('case_id', $case_id)
                ->get();

            $case = CaseModel::findOrFail($case_id);

            // Prepare documents grouped by pretrial_id
            $documentsByPretrial = [];
            foreach ($preTrials as $preTrial) {
                $documentsByPretrial[$preTrial->pretrial_id] = $preTrial->attachments->map(function ($attachment) {
                    return [
                        'attachment_id' =>$attachment->attachment_id,
                        'name' => $attachment->file_name,
                        'url' => asset('storage/documents/pretrial_attachments/' . $attachment->file_name)
                    ];
                })->toArray();
            }

            // ✅ Prepare members grouped by pretrial_id
            $membersByPretrial = [];
            foreach ($preTrials as $preTrial) {
                $membersByPretrial[$preTrial->pretrial_id] = $preTrial->members->map(function ($member) {
                    return [
                        'name' => $member->name,
                        'role_or_position' => $member->role_or_position,
                    ];
                })->toArray();
            }

            return view('pretrials.view', compact('preTrials', 'case', 'documentsByPretrial', 'membersByPretrial'));
        }

       public function all()
        {
            $user = Auth::user();

            if ($user && $user->role === 'Lawyer') {
                $lawyerId = $user->lawyer->lawyer_id ?? null;

                // Fetch only pretrials for cases the lawyer is assigned to
                $caseIds = CaseLawyer::where('lawyer_id', $lawyerId)->pluck('case_id');

                $preTrials = PreTrial::with(['members', 'attachments', 'case'])
                    ->whereIn('case_id', $caseIds)
                    ->get();
            } else {
                // Admins and others get all
                $preTrials = PreTrial::with(['members', 'attachments', 'case'])->get();
            }

            // Group documents by pretrial_id
            $documentsByPretrial = [];
            foreach ($preTrials as $preTrial) {
                $documentsByPretrial[$preTrial->pretrial_id] = $preTrial->attachments->map(function ($attachment) {
                    return [
                        'attachment_id' => $attachment->attachment_id,
                        'name' => $attachment->file_name,
                        'url' => asset('storage/documents/pretrial_attachments/' . $attachment->file_name),
                    ];
                })->toArray();
            }

            // Group members by pretrial_id
            $membersByPretrial = [];
            foreach ($preTrials as $preTrial) {
                $membersByPretrial[$preTrial->pretrial_id] = $preTrial->members->map(function ($member) {
                    return [
                        'name' => $member->name,
                        'role_or_position' => $member->role_or_position,
                    ];
                })->toArray();
            }

            return view('pretrials.index', compact('preTrials', 'documentsByPretrial', 'membersByPretrial'));
        }


    // Store a new pre-trial with members and attachments
    public function store(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'pretrial_date' => 'required|date',
            'pretrial_time' => 'required',
            'location' => 'nullable|string',
            'comments' => 'nullable|string',
            'members' => 'array',
            'attachments' => 'array',
        ]);

        // Save PreTrial
        $preTrial = PreTrial::create([
            'case_id' => $request->case_id,
            'pretrial_date' => $request->pretrial_date,
            'pretrial_time' => $request->pretrial_time,
            'location' => $request->location,
            'comments' => $request->comments,
        ]);

        // Save Members
        if ($request->has('members')) {
            foreach ($request->members as $member) {
                PreTrialMember::create([
                    'pretrial_id' => $preTrial->pretrial_id,
                    'member_type' => $member['member_type'],
                    'name' => $member['name'] ?? null,
                    'role_or_position' => $member['role_or_position'] ?? null,
                ]);
            }
        }

        // Save Attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                
                 $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/documents/pretrial_attachments', $fileName); 

                PreTrialAttachment::create([
                    'pretrial_id' => $preTrial->pretrial_id,
                    'file_name' =>$fileName,
                    'file_path' => $filePath,
                    'file_type' => $file->getClientMimeType(),
                    'upload_date' => now(),
                ]);
            }
        }

        return response()->json(['message' => 'Pre-trial created successfully', 'pretrial' => $preTrial]);
    }

            // Show a single pre-trial
        public function show($id)
        {
            $pretrial = PreTrial::with(['case', 'members', 'attachments'])->findOrFail($id);

            // Transform attachments to include URLs
            $attachments = $pretrial->attachments->map(function ($attachment) {
                return [
                    'attachment_id' => $attachment->attachment_id,
                    'name' => $attachment->file_name,
                    'url' => asset('storage/documents/pretrial_attachments/' . $attachment->file_name),
                ];
            });

            return response()->json([
                'pretrial' => [
                    'pretrial_id' => $pretrial->pretrial_id,
                    'pretrial_date' => $pretrial->pretrial_date,
                    'pretrial_time' => $pretrial->pretrial_time,
                    'created_at' => $pretrial->updated_at,
                    'updated_at' => $pretrial->created_at,
                    'comments' => $pretrial->comments,
                    'location' => $pretrial->location,
                    'members' => $pretrial->members,
                    'attachments' => $attachments,
                ],
                'case_name' => $pretrial->case->case_name ?? 'N/A',
                'case_number' => $pretrial->case->case_number ?? 'N/A',
            ]);
        }


    // Optional: update or delete methods can be added as needed


    public function deleteByName(Request $request)
{

    try{
         $name = $request->input('name');
    $pretrialId = $request->input('pretrial_id');

    $member = PreTrialMember::where('name', $name)
                ->where('pretrial_id', $pretrialId)
                ->first();

    if (!$member) {
        return response()->json(['success' => false, 'message' => 'Member not found.']);
    }

    $member->delete();

    return response()->json(['success' => true, 'message' => 'Member deleted successfully.']);
    }

    catch(\Exception $e){
         Log::error("Delete error: " . $e->getMessage());
    }
   
}

public function destroy($id)
{
    try {
        $preTrial = PreTrial::findOrFail($id);
        $preTrial->delete();

        return redirect()->back()->with('success', 'Pre-Trial deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete Pre-Trial: ' . $e->getMessage());
    }
}


 public function destroyDocument($attachmentId)
{
    Log::info("Received request to delete attachment_id with ID: " . $attachmentId);

    $document = PreTrialAttachment::where('attachment_id', $attachmentId)->first();
    
    if (!$document) {
        Log::error("Document not found with ID: " . $attachmentId);
        return response()->json(['success' => false, 'message' => 'Document not found'], 404);
    }

    // Delete the actual file from storage
    $deleted = Storage::delete('documents/pretrial_attachments/' . $document->file_name);

    if (!$deleted) {
        Log::warning("Failed to delete file: " . $document->file_name);
        // You can still continue if you want
    }

    // Delete the record from the database
    $document->delete();

    Log::info("Document deleted successfully: " . $document->file_name);

    return response()->json(['success' => true, 'message' => 'Document deleted successfully'], 200);
}


public function addAttachment(Request $request, $pretrial_id)
{
    try {
        $request->validate([
            'attachments' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');

            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/documents/pretrial_attachments', $fileName); 

            PreTrialAttachment::create([
                'pretrial_id' => $pretrial_id,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $file->getClientMimeType(),
                'upload_date' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'File uploaded.']);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.']);

    } catch (\Exception $e) {
        Log::error("Addition error: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.']);
    }
}




public function storeMembers(Request $request, $pretrialId)
{

    try {
        $validated = $request->validate([
        'members' => 'required|array',
        'members.*.member_type' => 'required|string',
        'members.*.name' => 'required|string',
        'members.*.role_or_position' => 'nullable|string',
    ]);

    foreach ($validated['members'] as $member) {
        PreTrialMember::create([
            'pretrial_id' => $pretrialId,
            'member_type' => $member['member_type'],
            'name' => $member['name'],
            'role_or_position' => $member['role_or_position'],
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Member(s) added successfully']);
        
    } catch (\Exception $e) {
        Log::error("Addition error: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.']);
    }
    
}

public function update(Request $request, $pretrialId)
{
    
    try {
        $request->validate([
        'pretrial_date' => 'required|date',
        'pretrial_time' => 'required',
        'location' => 'required|string|max:255',
        'comments' => 'nullable|string',
    ]);

    $preTrial = PreTrial::find($pretrialId);

    if (!$preTrial) {
        return response()->json(['success' => false, 'message' => 'Pre-Trial not found.'], 404);
    }

    $preTrial->update([
        'pretrial_date' => $request->pretrial_date,
        'pretrial_time' => $request->pretrial_time,
        'location' => $request->location,
        'comments' => $request->comments,
    ]);

    return response()->json(['success' => true, 'message' => 'Pre-Trial updated successfully.']);
    } catch (\Exception $e) {
        Log::error("Update error: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Something went wrong.']);
    }
    
}




}

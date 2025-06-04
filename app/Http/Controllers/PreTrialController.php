<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreTrial;
use App\Models\PreTrialMember;
use App\Models\PreTrialAttachment;
use App\Models\CaseModel;

class PreTrialController extends Controller
{
    

    
     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
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
        $preTrial = PreTrial::with(['members', 'attachments'])->findOrFail($id);
        return response()->json($preTrial);
    }

    // Optional: update or delete methods can be added as needed
}

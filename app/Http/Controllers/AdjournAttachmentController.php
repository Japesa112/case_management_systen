<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdjournAttachment;
use App\Models\Adjourn;
use Illuminate\Support\Facades\Storage;

class AdjournAttachmentController extends Controller
{
    /**
     * Upload and store attachments for an adjournment.
     */
    public function store(Request $request, $adjourns_id)
    {
        $request->validate([
            'attachments.*' => 'required|file|max:2048', // Max file size: 2MB
        ]);

        foreach ($request->file('attachments') as $file) {
            $filePath = $file->store('adjourn_attachments', 'public');

            AdjournAttachment::create([
                'adjourns_id' => $adjourns_id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientMimeType(),
                'upload_date' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Attachments uploaded successfully.');
    }

    /**
     * Delete an attachment.
     */
    public function destroy(AdjournAttachment $attachment)
    {
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return redirect()->back()->with('success', 'Attachment deleted successfully.');
    }
}

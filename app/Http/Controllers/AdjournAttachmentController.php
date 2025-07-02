<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdjournAttachment;
use App\Models\Adjourn;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdjournAttachmentController extends Controller
{
    /**
     * Upload and store attachments for an adjournment.
     */

     public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
    }

    public function store(Request $request, $adjourns_id)
    {
        $request->validate([
            // Your validation is good, keeping it.
            'attachments.*' => 'required|file|max:2048', // Max file size: 2MB per file
        ]);

        // Check if files were actually uploaded
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // 1. Create a unique filename to prevent overwrites and ensure consistency.
                $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                Log::info("time is: ".time());



                // 2. Use storeAs() to save the file with YOUR unique name on the 'public' disk.
                $file->storeAs('public/adjourn_attachments', $uniqueFileName);

                // 3. Create the database record, storing the unique name that matches the file.
                AdjournAttachment::create([
                    'adjourns_id' => $adjourns_id,
                    // Store the UNIQUE filename. This is the source of truth.
                    'file_name' => $uniqueFileName, 
                    // Store the original name separately for user-friendly display.
                    // NOTE: This requires adding an 'original_name' column to your table.
                    'file_path' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'upload_date' => now(),
                ]);
            }
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

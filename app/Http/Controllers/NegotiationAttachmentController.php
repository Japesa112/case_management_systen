<?php

namespace App\Http\Controllers;

use App\Models\NegotiationAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class NegotiationAttachmentController extends Controller
{
    /**
     * Display a listing of negotiation attachments.
     */

     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function index()
    {
        $attachments = NegotiationAttachment::all();
        return response()->json($attachments);
    }

    /**
     * Store a newly created attachment in storage.
     */
    public function store(Request $request, $negotiation)
    {
        try {
            // Validate file uploads. The negotiation id comes from the route.
            $validatedData = $request->validate([
                'modalAttachments' => 'required',
                'modalAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048',
            ]);
    
            $attachments = [];
            // Loop through each uploaded file
            foreach ($request->file('modalAttachments') as $file) {
               
                  $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                    Log::info("time is: ".time());

                    $file->storeAs('public/negotiation_attachments', $uniqueFileName);


    
                // Create an attachment record using the negotiation id from the route parameter
                $attachment = NegotiationAttachment::create([
                    'negotiation_id' => $negotiation,
                     'file_name' => $uniqueFileName, 
                    // Store the original name separately for user-friendly display.
                    // NOTE: This requires adding an 'original_name' column to your table.
                    'file_path' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
            
                ]);
                $attachments[] = $attachment;
            }
    
            // Redirect to negotiations index with a success message
        return redirect()->route('negotiations.index')
        ->with('success', 'Negotiation added successfully');

        } catch (\Exception $e) {


           redirect()->route('negotiations.index')
        ->with('error', $e->getMessage());
        }
    }
    


    /**
     * Display the specified attachment.
     */
    public function show($id)
    {
        $attachment = NegotiationAttachment::findOrFail($id);
        return response()->json($attachment);
    }

    /**
     * Update the specified attachment in storage.
     */
    public function update(Request $request, $id)
    {
        $attachment = NegotiationAttachment::findOrFail($id);

        $validatedData = $request->validate([
            'negotiation_id' => 'sometimes|required|exists:negotiations,negotiation_id',
            'file_name'      => 'sometimes|required|string|max:255',
            'file_path'      => 'sometimes|required|string|max:255',
            'file_type'      => 'nullable|string|max:50',
        ]);

        $attachment->update($validatedData);

        return response()->json([
            'message'    => 'Attachment updated successfully',
            'attachment' => $attachment,
        ]);
    }

    /**
     * Remove the specified attachment from storage.
     */
    public function destroy($attachment_id)
    {
        try {
            // Use where() and first() instead of firstOrFail() to avoid exceptions
            $attachment = NegotiationAttachment::where('attachment_id', $attachment_id)->first();
    
            if (!$attachment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attachment not found.: '.$attachment_id.'',
                ], 404);
            }
    
            // Delete the file from storage
            Storage::disk('public')->delete($attachment->file_path);
    
            // Delete the record from the database
            $attachment->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Attachment deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    



    public function store_edit(Request $request, $negotiation)
{
    try {
        // Validate file uploads
        $validatedData = $request->validate([
            'modalAttachments' => 'required',
            'modalAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $attachments = [];
        foreach ($request->file('modalAttachments') as $file) {
                $uniqueFileName = time() . '_' . $file->getClientOriginalName();

                    Log::info("time is: ".time());

                    $file->storeAs('public/negotiation_attachments', $uniqueFileName);


            // Store in database
            $attachment = NegotiationAttachment::create([
                'negotiation_id' => $negotiation,
                 'file_name' => $uniqueFileName, 
                    // Store the original name separately for user-friendly display.
                    // NOTE: This requires adding an 'original_name' column to your table.
                    'file_path' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
            ]);

            $attachments[] = [
                'id'        => $attachment->id,
                'file_name' => $uniqueFileName,
                'file_path' => asset('storage/' . $uniqueFileName),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Files uploaded successfully!',
            'attachments' => $attachments,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}


public function delete($attachment_id)
{
    try {
        
        // Find the attachment using the correct column name
        $attachment = NegotiationAttachment::where('attachment_id', $attachment_id)->firstOrFail();

        if (!$attachment) {
            return response()->json([
                'success' => false,
                'message' => 'Attachment not found.'
            ], 404);
        }

        // Delete the file from storage
        Storage::disk('public')->delete($attachment->file_name);

        // Delete the record from the database
        $attachment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attachment deleted successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting attachment: ' . $e->getMessage()
        ], 500);
    }
}

    
}

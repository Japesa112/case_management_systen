<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\CaseDocument;
use Illuminate\Support\Facades\Storage;
class CaseDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   
        public function store(Request $request, $case_id)
    {
        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        // Handle the file upload
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Unique name
            $filePath = $file->storeAs('public/documents', $fileName); // Save file

            // Store document details in the database
            CaseDocument::create([
                'case_id' => $case_id,
                'document_name' => $fileName, // Save only the filename, not the path
            ]);

            return redirect()->back()->with('success', 'Document uploaded successfully!');
        }

        return redirect()->back()->with('error', 'Failed to upload document.');
    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($case, $document_id)
    {
        try {
            $document = CaseDocument::where('document_id', $document_id)->firstOrFail();
    
            // Delete the file from storage
            Storage::delete('public/documents/' . $document->document_name);
    
            // Delete the record from the database
            $document->delete();
    
            return response()->json(['success' => 'Document deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete document: ' . $e->getMessage()], 500);
        }
    }
    
}

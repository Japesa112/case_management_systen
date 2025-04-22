<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = Payment::with('attachments')->get();
        return view('all_payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create($case_id) {
        $case_name = null;
        $payment = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('all_payments.create', compact('case_id', 'case_name', 'payment'));
    }
    
    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'amount_paid' => 'required|numeric',
                'payment_method' => 'required|string',
                'transaction' => 'nullable|string',
                'payment_date' => 'required|date',                
                'auctioneer_involvement' => 'nullable|string',
                'paymentAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048'
            ]);

            $payment = Payment::create($validatedData);

            if ($request->hasFile('paymentAttachments')) {
                foreach ($request->file('paymentAttachments') as $file) {
                    $filePath = $file->store('public/payment_attachments');
                    PaymentAttachment::create([
                        'payment_id' => $payment->payment_id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => str_replace('public/', 'storage/', $filePath),
                        'file_type' => $file->getClientOriginalExtension(),
                        'upload_date' => now()
                    ]);
                }
            }

            return redirect()->route('all_payments.index')->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified payment.
     */
    public function show($payment_id)
    {
        $payment= Payment::with('attachments')->where('payment_id', $payment_id)->firstOrFail();
    
        return response()->json([
            'case_name' => $payment->case->case_name,
            'payment' => $payment,
            'attachments' => $payment->attachments,
        ]);
    }
    
    /**
     * Show the form for editing the specified payment.
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
{
    try {
        $payment = Payment::findOrFail($id);

        $validatedData = $request->validate([
            'case_id' => 'required|exists:cases,case_id',
            'amount_paid' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction' => 'nullable|string',
            'payment_date' => 'required|date',
            'auctioneer_involvement' => 'nullable|string'
        ]);

        

        $payment->update($validatedData);

        return response()->json(['message' => 'Payment updated successfully.']);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error on payment update: ' . json_encode($e->errors()));
        return response()->json(['error' => 'Validation failed.', 'details' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Payment update error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update payment.'], 500);
    }
}


    /**
     * Remove the specified payment from storage.
     */
    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    /**
     * Delete a payment attachment.
     */
    public function deleteDocument($documentId)
    {

        Log::info('I am here. Checking if the deleteAttachment is working');
        try {
            $attachment = PaymentAttachment::findOrFail($documentId);
            Log::info('The path is: '. $attachment->file_path);
            Storage::delete($attachment->file_path);
            $attachment->delete();
            return response()->json(['message' => 'Attachment deleted successfully.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['error' => 'Failed to delete attachment.'], 500);
        }
    }

    /**
     * Upload a new attachment for a payment.
     */
    public function uploadAttachment(Request $request)
    {
        try {
            $request->validate([
                'payment_id' => 'required|exists:payments,payment_id',
                'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:4096'
            ]);

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filePath = $file->store('payment_attachments', 'public');

                $attachment = PaymentAttachment::create([
                    'payment_id' => $request->payment_id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => str_replace('public/', 'storage/', $filePath),
                    'file_type' => $file->getClientOriginalExtension(),
                    'upload_date' => now()
                ]);

                return response()->json(['message' => 'Attachment uploaded successfully!', 'attachment' => $attachment]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to upload attachment.'], 500);
        }
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
            
            return response()->json([
                'exists' => true,
                'case_id' => $case->case_id,
                'case_name' => $case->case_name,
                'payment' => null
            ]);
        } catch (\Exception $e) { 
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }


        
    }


}

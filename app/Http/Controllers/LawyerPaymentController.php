<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LawyerPayment;
use Illuminate\Support\Facades\Storage;
use App\Models\LawyerPaymentAttachment;
use Illuminate\Support\Facades\Log;
use App\Models\Lawyer;
use  Illuminate\Support\Facades\Auth;
class LawyerPaymentController extends Controller
{
    /**
     * Display a listing of the lawyer payments.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
    }

    public function index(Request $request)
{
    try {
        $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer';
        $filter = $request->query('filter'); // Read filter from query string

        $query = LawyerPayment::with('case');

        if ($isLawyer) {
            $lawyerId = Auth::user()->lawyer->lawyer_id;
            $query->where('lawyer_id', $lawyerId);
        }

        // Apply filter
        if ($filter === 'pending') {
            $query->where('lawyer_payment_status', 'pending');
        } elseif ($filter === 'completed') {
            $query->where('lawyer_payment_status', 'completed');
        }
        // No filter = all payments (total)

        $payments = $query->get();

        return view('lawyer_payments.index', compact('payments'));

    } catch (\Exception $e) {
        Log::error("Payment index error: " . $e->getMessage());
        abort(500, 'An error occurred while loading payments.');
    }
}

    


    public function getLawyers()
{
    $lawyers = Lawyer::with('user')->get()->map(function ($lawyer) {
        return [
            'lawyer_id' => $lawyer->lawyer_id,
            'display_name' => $lawyer->user->full_name . ' - ' . $lawyer->license_number
        ];
    });

    return response()->json($lawyers);
}

    /**
     * Show the form for creating a new lawyer payment.
     */
    public function create($case_id)
    {
        $case_name = null;
        $lawyerPayment = null;

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
            }
        }

        return view('lawyer_payments.create', compact('case_id', 'case_name', 'lawyerPayment'));
    }

    /**
     * Store a newly created lawyer payment in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'payment_lawyer' => 'required|exists:lawyers,lawyer_id',
                'amount_paid' => 'required|numeric',
                'payment_method' => 'required|string',
                'transaction' => 'nullable|string',
                'payment_date' => 'required|date_format:Y-m-d\TH:i',
                'lawyer_payment_status' => 'required|string|in:Pending,Completed,Failed',
                'lawyerPaymentAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // File validation
            ]);

            Log::info('Lawyer Payment Request Data:', $request->all());
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->payment_date);
            $payment_date = $dateTime->toDateString();
            $payment_time = $dateTime->toTimeString();


            // Create the lawyer payment record
            $lawyerPayment = LawyerPayment::create([
                'case_id' => $request->case_id,
                'lawyer_id' => $request->payment_lawyer,
                'amount_paid' => $request->amount_paid,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'payment_date' => $payment_date,
                'payment_time' => $payment_time,
                'lawyer_payment_status' => $request->lawyer_payment_status,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Lawyer Payment Created:', $lawyerPayment->toArray());

            // Handle file uploads
            if ($request->hasFile('lawyerPaymentAttachments')) {
                foreach ($request->file('lawyerPaymentAttachments') as $file) {
                    $filePath = $file->store('public/lawyer_payment_attachments');
                    $fileName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension();

                    LawyerPaymentAttachment::create([
                        'lawyer_payment_id' => $lawyerPayment->payment_id,
                        'file_name' => $fileName,
                        'file_path' => str_replace('public/', 'storage/', $filePath),
                        'file_type' => $fileType,
                        'upload_date' => now()
                    ]);
                }
            }

            return redirect()->route('lawyer_payments.index', ['case_id' => $request->case_id])
                ->with('success', 'Lawyer payment created successfully.');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified lawyer payment.
     */
    public function show($lawyer_payment_id)
    {
        try {
            $lawyerPayment = LawyerPayment::with('attachments')->where('payment_id', $lawyer_payment_id)->firstOrFail();
            Log::info('', $lawyerPayment->toArray());
            $formattedDateTime = $lawyerPayment->payment_date && $lawyerPayment->payment_time
            ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$lawyerPayment->payment_date $lawyerPayment->payment_time")->format('Y-m-d\TH:i')
            : '';
            return response()->json([
                'case_name' => $lawyerPayment->case->case_name,
                'lawyer_id' => $lawyerPayment->lawyer_id,
                'lawyer' => $lawyerPayment->lawyer->license_number.'-'. $lawyerPayment->lawyer->user->full_name,
                'payment' => $lawyerPayment,
                'attachments' => $lawyerPayment->attachments,
                'formattedDateTime'=> $formattedDateTime
            ]);
        } catch (\Exception $e) {
            Log::info("The show function is not working");
            Log::error($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified lawyer payment.
     */
    public function edit($id)
    {
        $lawyerPayment = LawyerPayment::findOrFail($id);
        return view('lawyerPayments.edit', compact('lawyerPayment'));
    }

    /**
     * Update the specified lawyer payment in storage.
     */
    public function update(Request $request)
    {
        Log::info('Received Data:', $request->all());

        $lawyerPayment = LawyerPayment::find($request->payment_id);

        if (!$lawyerPayment) {
            Log::error("Lawyer Payment not found for ID: " . $request->payment_id);
            return response()->json(['error' => 'Lawyer Payment not found.'], 404);
        }

        try {
            // Validate request data
            $request->validate([
                'case_id' => 'required|exists:cases,case_id',
                'payment_lawyer' => 'required|exists:lawyers,lawyer_id',
                'amount_paid' => 'required|numeric',
                'payment_method' => 'required|string',
                'transaction' => 'nullable|string',
                'payment_date' => 'required|date_format:Y-m-d\TH:i',
                'lawyer_payment_status' => 'required|string|in:Pending,Completed,Failed',
                'lawyerPaymentAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048' // Validate file uploads
            ]);
            $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->payment_date);
            $lawyerPayment['payment_date'] = $dateTime->toDateString();
            $lawyerPayment['payment_time'] = $dateTime->toTimeString();

            // Update lawyer payment details
            $lawyerPayment->update($request->all());

            Log::info("Updated Lawyer Payment: ", [$lawyerPayment]);

            return response()->json(['message' => 'Lawyer Payment updated successfully.']);

        } catch (\Exception $e) {
            Log::error("Update failed: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update Lawyer Payment.'], 500);
        }
    }

    /**
     * Remove the specified lawyer payment from storage.
     */
    public function destroy($id)
    {
        LawyerPayment::findOrFail($id)->delete();
        return redirect()->route('lawyer_payments.index')->with('success', 'Lawyer Payment deleted successfully.');
    }

    public function deleteDocument($documentId)
    {
        Log::info('The document having an id of '. $documentId .' has been deleted ');

        try {
            $document = LawyerPaymentAttachment::where('attachment_id', $documentId)->firstOrFail();

            if (!$document) {
                return response()->json(['message' => 'Document not found'], 404);
            }

            // Delete file from storage
            Log::info('The document path is: '. $document->file_path);
            if (!empty($document->file_path)) {
                Storage::delete($document->file_path);
            }

            // Delete from database
            $document->delete();

            return response()->json(['message' => 'Document deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete document: ' . $e->getMessage()], 500);
        }
    }

    public function uploadAttachment(Request $request)
    {
        Log::info('Received Data:', $request->all());

        try {
            $request->validate([
                'payment_id' => 'required|exists:lawyer_payments,payment_id',
                'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:4096',
            ]);

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filePath = $file->store('lawyer_payment_attachments', 'public');
                $fileName = $file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();

                $document = LawyerPaymentAttachment::create([
                    'lawyer_payment_id' => $request->payment_id,
                    'file_name' => $fileName,
                    'file_path' => str_replace('public/', 'storage/', $filePath),
                    'file_type' => $fileType,
                    'upload_date' => now()
                ]);

                return response()->json(['message' => 'Document uploaded successfully!', 'document' => $document]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to upload file'], 500);
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

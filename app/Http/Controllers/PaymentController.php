<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentAttachment;

use App\Models\Lawyer;
use App\Models\Complainant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */

     public function __construct()
    {
        $this->middleware('auth'); // Applies to all methods in the controller
    }

 public function index(Request $request)
{
    $filter = $request->query('filter');

    $query = Payment::with(['attachments', 'lawyer.user', 'complainant']);

    if ($filter === 'overdue') {
        $query->where('payment_status', '!=', 'completed')
              ->whereDate('due_date', '<', now());
    } elseif ($filter === 'kenyatta_university') {
        $query->where('payee', 'kenyatta_university');
    }

    $payments = $query->get();

    return view('all_payments.index', compact('payments'));
}


    /**
     * Show the form for creating a new payment.
     */
    public function create($case_id) {
        $case_name = null;
        $payment = null;
        $complainants = Complainant::all();
        $lawyers = Lawyer::all();

        if ($case_id) {
            // Retrieve the case record based on the provided case_id
            $caseRecord = \App\Models\CaseModel::find($case_id);
            if ($caseRecord) {
                $case_name = $caseRecord->case_name;
               // $negotiation = $caseRecord->negotiations()->latest()->with('attachments')->first();
    
            }
        }

        return view('all_payments.create', compact('case_id', 'case_name', 'payment', 'complainants', 'lawyers'));
    }
    
    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        try {
           $validatedData = $request->validate([
                        'case_id' => 'required|exists:cases,case_id',
                        'payee' => 'required|in:kenyatta_university,complainant,lawyer,other',
                        'payee_id' => 'nullable|integer', // Will be validated conditionally below
                        'amount_paid' => 'required|numeric',
                        'payment_method' => 'required|string',
                         'payment_status' => 'required|string',
                        'transaction' => 'nullable|string',
                        'payment_date' => 'required|date_format:Y-m-d\TH:i',
                        'due_date' => 'required|date_format:Y-m-d\TH:i',
                        'auctioneer_involvement' => 'nullable|string',
                        'paymentAttachments.*' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048'
                    ]);

                   

                    // Split payment_date into date and time
                    $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['payment_date']);
                    $validatedData['payment_date'] = $dateTime->toDateString();
                    $validatedData['payment_time'] = $dateTime->toTimeString();


                    $dateDueTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['due_date']);
                    $validatedData['due_date'] = $dateDueTime->toDateString();
                    $validatedData['due_time'] = $dateDueTime->toTimeString();

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
    $payment = Payment::with('attachments')->where('payment_id', $payment_id)->firstOrFail();

    // Format payment date and due date+time
    $formattedDateTime = $payment->payment_date && $payment->payment_time
        ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$payment->payment_date $payment->payment_time")->format('Y-m-d\TH:i')
        : '';

    $formattedDateDueTime = $payment->due_date && $payment->due_time
        ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', "$payment->due_date $payment->due_time")->format('Y-m-d\TH:i')
        : '';

    // Determine recipient name
    $recipientName = null;

    if ($payment->payee === 'complainant') {
        $complainant = \App\Models\Complainant::find($payment->payee_id);
        $recipientName = $complainant ? $complainant->complainant_name . ' (Complainant)' : null;

    } elseif ($payment->payee === 'lawyer') {
        $lawyer = \App\Models\Lawyer::with('user')->find($payment->payee_id);
        $recipientName = $lawyer && $lawyer->user ? $lawyer->user->full_name . ' (Lawyer)' : null;

    } elseif ($payment->payee === 'kenyatta_university') {
        $recipientName = 'Kenyatta University';

    } elseif ($payment->payee === 'other') {
        $recipientName = 'Other';
    }

    return response()->json([
        'case_name' => $payment->case->case_name,
        'payment' => $payment,
        'attachments' => $payment->attachments,
        'formattedDateTime' => $formattedDateTime,
        'formattedDateDueTime' => $formattedDateDueTime,
        'recipient_name' => $recipientName,
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
                        'payee' => 'required|in:kenyatta_university,complainant,lawyer,other',
                        'payee_id' => 'nullable|integer', // Will be validated conditionally below
                        'amount_paid' => 'required|numeric',
                        'payment_method' => 'required|string',
                        'transaction' => 'nullable|string',
                        'payment_status' => 'required|string',
                        'payment_date' => 'required|date_format:Y-m-d\TH:i',
                        'due_date' => 'required|date_format:Y-m-d\TH:i',
                        'auctioneer_involvement' => 'nullable|string'
        ]);

        Log::info("The payee_id is: ".$request->payee_id);

        $dateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->payment_date);
        $validatedData['payment_date'] = $dateTime->toDateString();
        $validatedData['payment_time'] = $dateTime->toTimeString();

         $dateDueTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['due_date']);
         $validatedData['due_date'] = $dateDueTime->toDateString();
         $validatedData['due_time'] = $dateDueTime->toTimeString();

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




        public function getPaymentStats()
        {
            $now = Carbon::now();

            // Total amount paid (all completed payments)
            $totalPayments = Payment::where('payment_status', 'completed')->sum('amount_paid');

            // Total paid to Kenyatta University
            $universityPayments = Payment::where('payment_status', 'completed')
                ->where('payee', 'kenyatta_university')
                ->sum('amount_paid');

            // Overdue payments: pending and due date passed
            $overduePayments = Payment::where('payment_status', 'pending')
                ->whereDate('due_date', '<', $now)
                ->count();

            // Pie chart data
            $paymentToLawyers = Payment::where('payment_status', 'completed')
                ->where('payee', 'lawyer')
                ->sum('amount_paid');

            $paymentToComplainants = Payment::where('payment_status', 'completed')
                ->where('payee', 'complainant')

                ->sum('amount_paid');

            $paymentToOthers = Payment::where('payment_status', 'completed')
                ->where('payee', 'other')
                ->sum('amount_paid');

            return response()->json([
                'totalPayments' => number_format($totalPayments, 2),
                'universityPayments' => number_format($universityPayments, 2),
                'overduePayments' => $overduePayments,
                'chartData' => [
                    'lawyers' => $paymentToLawyers,
                    'complainants' => $paymentToComplainants,
                    'others' => $paymentToOthers,
                ]
            ]);
        }

public function getPaymentDates(Request $request)
{
    $start = $request->query('start');
    $end   = $request->query('end');
    $group = $request->query('groupBy', 'daily');

    $q = Payment::where('payment_status', 'completed');

    if ($start) $q->whereDate('payment_date', '>=', $start);
    if ($end)   $q->whereDate('payment_date', '<=', $end);

    $payments = $q->get();

    // group & sum
    $grouped = $payments
        ->groupBy(function($p) use ($group) {
            $d = \Carbon\Carbon::parse($p->payment_date);
            return match($group) {
                'weekly'  => $d->startOfWeek()->format('Y-m-d') . ' – ' . $d->endOfWeek()->format('Y-m-d'),
                'monthly' => $d->format('F Y'),
                default   => $d->format('Y-m-d'),
            };
        })
        ->map(function($group) {
            // sum up amount_paid (cast to float)
            return $group->sum(fn($p)=>(float)$p->amount_paid);
        });

    return response()->json([
        'labels'  => $grouped->keys()->all(),
        'amounts' => $grouped->values()->all(),
    ]);
}




public function getPaymentsByDate(Request $request)
{
    

     try {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $singleDate = $request->input('date'); // fallback for single date

        $query = Payment::query()->with(['lawyer.user', 'complainant', 'case']);

        if ($startDate && $endDate) {
            // Filter between start and end date
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        } elseif ($singleDate) {
            // Filter by a single date
            $query->whereDate('payment_date', $singleDate);
        } else {
            // No filter - optional: return empty or all (up to you)
            return response()->json([]);
        }

        $payments = $query->get();

        $data = $payments->map(function ($payment) {
            $payeeName = 'Unknown';

            switch ($payment->payee) {
                case 'lawyer':
                    $payeeName = $payment->lawyer && $payment->lawyer->user
                        ? $payment->lawyer->user->full_name . " - " . $payment->lawyer->license_number
                        : 'Lawyer';
                    break;

                case 'complainant':
                    $payeeName = $payment->complainant
                        ? $payment->complainant->complainant_name
                        : 'Complainant';
                    break;

                case 'kenyatta_university':
                    $payeeName = 'Kenyatta University';
                    break;

                case 'other':
                    $payeeName = 'Other';
                    break;
            }

            return [
                'case_name' => $payment->case ? $payment->case->case_name : 'N/A',
                'payee' => $payeeName,
                'amount_paid' => $payment->amount_paid,
                'payment_method' => $payment->payment_method,
                'payment_status' => $payment->payment_status,
                'payment_date' => $payment->payment_date,
            ];
        });

        return response()->json($data);

    } catch (\Exception $e) {
        Log::error('Error in getPaymentsByDateRange: ' . $e->getMessage(), [
            'stack' => $e->getTraceAsString()
        ]);

        return response()->json(['error' => 'Failed to fetch payments'], 500);
    }


}


}

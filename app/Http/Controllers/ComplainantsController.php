<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Complainant;
use App\Mail\CaseNotification;
use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use App\User;

class ComplainantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'block-lawyer']); // Applies to all methods in the controller
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $complainant_id)
{
    try {
        
        // Log complainant_id
        Log::info('Updating complainant with ID: ' . $complainant_id. " Case Id: " . $request->case_id);

        // Validate input
        $validatedData = $request->validate([
            'complainant_name' => 'required|string|max:255',
            'phone'            => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string|max:255',
        ]);
       $validatedData['case_id'] = $request->case_id;
        // Find complainant and update
        $complainant = Complainant::where('complainant_id', $complainant_id)->firstOrFail();
        // Log complainant data before update
        Log::info('Found complainant:', $complainant->toArray());
        $complainant->update($validatedData);

        Log::info('Updated complainant:', $complainant->toArray());

        // 🔔 Create Notification
        $notification = Notification::create([
            'title'   => 'Complainant Updated',
            'message' => "The complainant '{$validatedData['complainant_name']}' has been updated for case ID {$validatedData['case_id']}.",
            'type'    => 'complainant_updated',
            'icon'    => 'fa fa-user-edit', // FontAwesome icon
        ]);

        $totalNotified = 0;
        User::select('user_id')->chunkById(200, function ($users) use ($notification, &$totalNotified) {
            $now = now();
            $insertData = $users->map(function ($user) use ($notification, $now) {
                return [
                    'user_id'         => $user->user_id,
                    'notification_id' => $notification->notification_id,
                    'is_read'         => false,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            })->toArray();

            DB::table('user_notification')->insert($insertData);
            $totalNotified += count($insertData);
        });

        Log::info("Complainant update notification sent to {$totalNotified} users", [
            'notification_id' => $notification->notification_id,
            'complainant_id'  => $complainant_id,
            'case_id'         => $validatedData['case_id'],
        ]);

        return response()->json([
            'success' => 'Complainant updated successfully!',
            'complainant' => $complainant
        ]);
    } catch (\Exception $e) {
        Log::error('Error updating complainant: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update complainant: ' . $e->getMessage()], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

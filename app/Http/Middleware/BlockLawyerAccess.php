<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseLawyer;
class BlockLawyerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Only check if user is a lawyer
        if ($user && $user->role === 'Lawyer') {
            $lawyerId = $user->lawyer->lawyer_id ?? null;

            // Try to extract case_id from route params
            $caseId = $request->route('case_id') ?? $request->route('id');

            if ($caseId) {
                // If case_id is present, check if lawyer is assigned
                $isAssigned = CaseLawyer::where('lawyer_id', $lawyerId)
                    ->where('case_id', $caseId)
                    ->exists();

                if (!$isAssigned) {
                    abort(403, 'Unauthorized access. You are not assigned to this case.');
                }
            }

            // Either assigned or it's a general route with no specific case
            return $next($request);
        }

        // Non-lawyers are not allowed
        return $next($request);
    }
}

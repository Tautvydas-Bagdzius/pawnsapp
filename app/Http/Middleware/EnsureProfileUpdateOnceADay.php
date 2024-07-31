<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Profile;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileUpdateOnceADay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userUpdatedAt = $request->user()->updated_at;
        $profilingQuestions = $request->user()->profile()->get();
        $maxUpdatedAt = $profilingQuestions->max('updated_at');

        if ($userUpdatedAt->isToday() || $maxUpdatedAt->isToday()) {
            return response()->json([
                'message'=> 'You can only update profile once a day.',
                'errors' => (object)[
                    'profile' => 'You have already updated profiling questions today',
                ],
            ], 422);
        }

        return $next($request);
    }
}

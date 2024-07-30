<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProfilingQuestion;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfilingAnswers;

class UserController extends Controller
{
    /**
     * Return wallet of current user
     */
    public function wallet(Request $request): JsonResponse
    {
        $user = $request->user();
        $wallet = $user->wallet()
            ->select([
                'id',
                'balance',
                'balance_pending',
                'count_unclaimed_points_transactions',
            ])->first();

        return response()->json($wallet);
    }

    /**
     * Update user's profile with profiling question answers
     */
    public function update(UpdateUserProfilingAnswers $request)
    {
        foreach ($request->input() as $key => $value) {
            $question = ProfilingQuestion::where('slug', $key)->first();

            $profiledQuestion = $request->user()->profile()
                ->firstOrNew(['question_id' => $question->id]);
            $profiledQuestion->answer = $value;
            $profiledQuestion->save();
        }

        return response()->json([
            'message' => 'Profile updated successfully!',
        ]);
    }
}

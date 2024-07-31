<?php

namespace App\Http\Controllers\Api;

use App\Events\UserUpdatedProfilingAnswers;
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
            $profiledQuestion->updated_at = now(); // Touching to update datetime even if answers are identical
            $profiledQuestion->save();
        }

        UserUpdatedProfilingAnswers::dispatch($request->user());

        return response()->json([
            'message' => 'Profile updated successfully!',
        ]);
    }

    /**
     * Return a list of transactions, created by current user
     * Not sure if current user or /users/{id}/transactions was the idea there
     */
    public function transactions(Request $request): JsonResponse
    {
        $transactions = $request->user()->transactions
            ->select(['points', 'is_claimed', 'created_at']);

        return response()->json($transactions);
    }
}

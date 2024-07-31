<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Events\PointsClaimed;
use App\Traits\PointsConversion;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionController extends Controller
{
    use PointsConversion;

    /**
     * Return a list of transactions, created by current user
     * Not sure if current user or /users/{id}/transactions was the idea there
     */
    public function list(Request $request): JsonResponse
    {
        $transactions = $request->user()->transactions
            ->select(['points', 'is_claimed', 'created_at']);

        return response()->json($transactions);
    }

    /**
     * Claim point transactions
     */
    public function claim(Request $request): JsonResponse
    {
        $user = $request->user();
        $unclaimedTransactions = $user->transactions()->where('is_claimed', false);

        if ($unclaimedTransactions->count() === 0) {
            return response()->json([
                'message' => 'You do not have a any unclaimed points.'
            ], 422);
        }

        return $this->claimTransactions($user, $unclaimedTransactions);
    }

    /**
     * Perform points claim
     */
    private function claimTransactions(User $user, HasMany $unclaimedTransactions): JsonResponse
    {
        $transactions = $unclaimedTransactions->get();
        $unclaimedTransactions->update([
            'is_claimed' => true,
            'claimed_at' => Carbon::now(),
        ]);

        PointsClaimed::dispatch($user, $transactions);

        return response()->json([
            'message' => 'Points claimed successfully',
            'amount' => $transactions->sum('points'),
        ]);
    }
}

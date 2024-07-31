<?php

namespace App\Models;

use App\Traits\PointsConversion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, PointsConversion;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'balance',
        'balance_pending',
        'count_unclaimed_points_transactions',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Recalculate and save updated wallet into
     */
    public function recalculate()
    {
        $transactions = $this->user->transactions;
        $unclaimedPointsAmount = $transactions->where('is_claimed', false)->sum('points');
        $claimedPointsAmount = $transactions->where('is_claimed', true)->sum('points');

        $this->balance = $this->pointsToUsd($claimedPointsAmount);
        $this->balance_pending = $this->pointsToUsd($unclaimedPointsAmount);
        $this->count_unclaimed_points_transactions = $transactions->where('is_claimed', false)->count();
        $this->save();
    }
}

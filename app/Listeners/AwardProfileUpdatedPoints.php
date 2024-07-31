<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserUpdatedProfilingAnswers;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\Transaction;

class AwardProfileUpdatedPoints
{
    const POINTS_FOR_PROFILE_UPDATE = 5;    

    /**
     * Create the event listener.
     */
    public function __construct(User $user)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserUpdatedProfilingAnswers $event): void
    {
        Transaction::create([
            'user_id' => $event->user->id,
            'points' => self::POINTS_FOR_PROFILE_UPDATE,
            'is_claimed' => false,
        ]);
    }
}

<?php

namespace App\Listeners;

use App\Events\PointsClaimed;
use App\Mail\PointsClaimed as MailPointsClaimed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPointsClaimed
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PointsClaimed $event): void
    {
        $user = $event->user;
        $user->wallet->recalculate();

        Mail::to($user)->send(new MailPointsClaimed($user, $event->transactions));
    }
}

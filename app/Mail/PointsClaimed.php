<?php

namespace App\Mail;

use App\Models\User;
use App\Traits\PointsConversion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class PointsClaimed extends Mailable
{
    use Queueable, SerializesModels, PointsConversion;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public Collection $transactions)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Points Claimed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.points.claimed',
            with: [
                'usdAmount' => $this->pointsToUsd($this->transactions->sum('points')),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

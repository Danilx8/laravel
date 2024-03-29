<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class MailSender extends Mailable
{
    use Queueable, SerializesModels;

    protected $comment;

    /**
     * Create a new message instance.
     */
    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->view('mail.comment')
                    ->with([
                        'comment' => $this->comment
                    ]);
    }
}

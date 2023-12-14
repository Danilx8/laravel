<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleMailStats extends Mailable
{
    use Queueable, SerializesModels;

    protected $articleCount;
    protected $commentCount;
    public function __construct(int $articleCount, int $commentCount)
    {
        $this->articleCount = $articleCount;
        $this->commentCount = $commentCount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->view('mail.stats')
                    ->with([
                        'articleCount' => $this->articleCount,
                        'commentCount' => $this->commentCount,
                    ]);
    }
}

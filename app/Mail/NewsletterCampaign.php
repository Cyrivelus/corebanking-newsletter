<?php
// app/Mail/NewsletterCampaign.php

namespace App\Mail;

use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // <--- Ajoutez ceci
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterCampaign extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $subject;
    public $content;

    public function __construct(Newsletter $subscriber, string $subject, string $content)
    {
        $this->subscriber = $subscriber;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.newsletter-campaign');
    }
}

<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class WelcomeMail extends Mailable
{
    public function __construct(public string $content) {}

    public function build()
    {
        return $this->subject('OKX')
                    ->view('email')
                    ->with([
                        'content' => $this->content,
                    ]);
    }
}

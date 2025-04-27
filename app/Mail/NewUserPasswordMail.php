<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Account Password')
                    ->markdown('emails.new-user-password');
    }
}

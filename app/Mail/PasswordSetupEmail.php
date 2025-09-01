<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordSetupEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $loginLink;

    public function __construct(User $user, $password, $loginLink)
    {
        $this->user = $user;
        $this->password = $password;
        $this->loginLink = $loginLink;
    }

    public function build()
    {
        return $this->subject('Your Account Details')
                    ->view('emails.password_setup')
                    ->with([
                        'user' => $this->user,
                        'password' => $this->password,
                        'loginLink' => $this->loginLink, // تمرير رابط تسجيل الدخول
                    ]);
    }
}


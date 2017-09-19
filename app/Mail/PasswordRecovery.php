<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordRecovery extends Mailable
{
    use Queueable, SerializesModels;
    public $user;

    /**
     * Create a new message instance.
     *
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.password_recovery')
            ->from('')
            ->to($this->user->email)
            ->subject('Recuperación de contraseña');
    }
}

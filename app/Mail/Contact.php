<?php

namespace App\Mail;

use App\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.contact')
            ->from('contacto@ejsoluciones.com.ve')
            ->to('contacto@ejsoluciones.com.ve')
            ->subject('contacto');
        
//        return $this->view('email.contact')
//            ->from('comercial@buildoor.co')
//            ->to('comercial@buildoor.co')
//            ->subject('contacto');
    }
}

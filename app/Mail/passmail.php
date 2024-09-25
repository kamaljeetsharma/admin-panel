<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Passmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $password
     * @return void
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail') // Ensure this view exists
                    ->with([
                        'name' => $this->name,
                        'password' => $this->password,
                    ])
                    ->subject('Password Email');
    }
}

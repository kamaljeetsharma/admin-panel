<?php

namespace App\Jobs;

use App\Mail\passmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;  // Add Dispatchable
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordMail implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $email;  // Add the email property
    protected $name;
    protected $password;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $name
     * @param string $password
     * @return void
     */
    public function __construct($email, $name, $password)  // Accept email
    {
        $this->email = $email;   // Assign email
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the password email
        Mail::to($this->email)->send(new passmail($this->email, $this->password));  // Use email instead of name
    }
}

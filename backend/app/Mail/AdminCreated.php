<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->from('from@example.com')
                    ->subject('Admin Account Created')
                    ->view('emails.admin.created')
                    ->with([
                        'name' => $this->user->prenom,
                        'password' => $this->password,
                    ]);
    }
}
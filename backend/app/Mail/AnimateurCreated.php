<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnimateurCreated extends Mailable
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
                    ->subject('Welcome to Our Platform!')
                    ->view('emails.animateur.created')
                    ->with([
                        'name' => $this->user->nom,
                        'password' => $this->password,
                    ]);
    }
}
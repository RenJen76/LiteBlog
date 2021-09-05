<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
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
        $verifyUrl = url('verifyUser/' . encrypt($this->user->id));
        return $this->view('email.notification')
                    ->subject('發信通知')
                    ->with([
                        'nickName' => $this->user->nickname,
                        'verifyUrl'=> $verifyUrl
                    ]);
    }
}

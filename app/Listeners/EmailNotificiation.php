<?php

namespace App\Listeners;

use Mail;
use App\Events\UserEvents;
use App\Mail\RegisterNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotificiation implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserEvents  $event
     * @return void
     */
    public function handle(UserEvents $event)
    {
        $userEmail = $event->user->email;
        Mail::to($userEmail)->send(new RegisterNotification($event->user));
    }
}

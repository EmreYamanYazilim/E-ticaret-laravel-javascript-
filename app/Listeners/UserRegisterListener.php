<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use App\Mail\UserWelcomeMail;
use App\Events\UserRegisterEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisterListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegisterEvent $event): void
    {
        $token = Str::random(40);

        // Ön bellekte  60 dk boyunca tokeni saklayacak
        Cache::put('verify_token_' . $token, $event->user->id, 3600);
        Mail::to($event->user->email)->send(new UserWelcomeMail($event->user, $token));
        dd($event->user);
    }
}
<?php

namespace App\Listeners;

use App\Notifications\WelcomeMailNotification;
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



        // observe işlemleri için artık event fırlatmıyoruz oyüzden yorum satırına alıyorum listener ve notification işlemeri için eventimizi kenarda tutuyorum
        //notification ile email işlemleri
        // $event->user->notify(new WelcomeMailNotification($token));

        //aynı işlemi notification ile işlemi yapacağım için bunu yorum satırına aldım
        // Mail::to($event->user->email)->send(new UserWelcomeMail($event->user, $token));

    }
}

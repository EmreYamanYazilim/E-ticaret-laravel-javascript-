<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Notifications\WelcomeMailNotification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // listener içinde yaptığımız token cache notify işlemlerimizi artık obsherver içinde yapıyoruz

        $token = Str::random(40);
        // Ön bellekte  60 dk boyunca tokeni saklayacak
        Cache::put('verify_token_' . $token, $user->id, 3600);
        $user->notify(instance: new WelcomeMailNotification($token));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('email_verified_at'))
        {
            Cache::forget('verify_token_' . request()->token);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

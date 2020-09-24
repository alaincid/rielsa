<?php

namespace App\Listeners;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Middleware\LastUserActivity;
use App\Events\UserSessionChanged;
use Cache;


class BroadcastUserSessionChanged
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
     * @param  object  $event
     * @return void
     */
    public function handle(handle $event)
    {
        broadcast(new UserSessionChanged(Cache::has('user-is-online-' . $this->id)));
    }
}

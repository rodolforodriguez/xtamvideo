<?php

namespace App\Listeners;

use App\Events\AlarmStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlarmStatusChangedListener
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
     * @param  AlarmStatusChanged  $event
     * @return void
     */
    public function handle(AlarmStatusChanged $event)
    {
        //
    }
}

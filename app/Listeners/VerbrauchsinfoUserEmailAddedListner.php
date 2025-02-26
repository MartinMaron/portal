<?php

namespace App\Listeners;

use App\Events\VerbrauchsinfoUserEmailAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerbrauchsinfoUserEmailAddedListner
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
     * @param  \App\Events\VerbrauchsinfoUserEmailAdded  $event
     * @return void
     */
    public function handle(VerbrauchsinfoUserEmailAdded $event)
    {
        $event->verbrauchsinfoUserEmail->save();   
    }
}

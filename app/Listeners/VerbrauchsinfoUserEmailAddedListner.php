<?php

namespace App\Listeners;

use App\Events\VerbrauchsinfoUserEmailAdded;

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
     * @return void
     */
    public function handle(VerbrauchsinfoUserEmailAdded $event)
    {
        $event->verbrauchsinfoUserEmail->save();
    }
}

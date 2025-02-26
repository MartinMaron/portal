<?php

namespace App\Listeners;

use App\Events\CostUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Usernotnull\Toast\Concerns\WireToast;

class CostUpdatedNotification
{
    Use WireToast;

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
     * @param  \App\Events\CostUpdated  $event
     * @return void
     */
    public function handle(CostUpdated $event)
    {
        toast()->success('Speichervorgang erfolgreich','Achtung')->push();       
    }
}

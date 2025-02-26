<?php

namespace App\Listeners;

use App\Events\CostAmountDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Contracts\Queue\ShouldQueue;

class CostAmountDeletedNotification
{
    use WireToast; 
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
     * @param  \App\Events\CostAmountDeleted  $event
     * @return void
     */
    public function handle(CostAmountDeleted $event)
    {
        toast()->success('Betrag '. $event->costAmount->brutto. ' € wurde gelöscht' ,'Achtung')->push();  
    }
}

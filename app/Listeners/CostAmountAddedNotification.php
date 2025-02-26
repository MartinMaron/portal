<?php

namespace App\Listeners;

use App\Events\CostAmountAdded;
use Illuminate\Queue\InteractsWithQueue;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Contracts\Queue\ShouldQueue;

class CostAmountAddedNotification
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
     * @param  \App\Events\CostAmountAdded  $event
     * @return void
     */
    public function handle(CostAmountAdded $event)
    {
        toast()->success('Betrag '. $event->costAmount->brutto. ' € hinzugefügt' ,'Achtung')->push(); 
    }
}

<?php

namespace App\Listeners;

use App\Events\CostAmountUpdated;
use Usernotnull\Toast\Concerns\WireToast;

class CostAmountUpdatedNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(CostAmountUpdated $event)
    {
       /*  toast()->success('Betrag '.$event->costAmount->brutto.' € geändert', 'Achtung')->push(); */
    }
}

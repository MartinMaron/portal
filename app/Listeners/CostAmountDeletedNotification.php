<?php

namespace App\Listeners;

use App\Events\CostAmountDeleted;
use Usernotnull\Toast\Concerns\WireToast;

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
     * @return void
     */
    public function handle(CostAmountDeleted $event)
    {
        toast()->success('Betrag '.$event->costAmount->brutto.' € wurde gelöscht', 'Achtung')->push();
    }
}

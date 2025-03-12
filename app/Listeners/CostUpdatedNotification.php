<?php

namespace App\Listeners;

use App\Events\CostUpdated;
use Usernotnull\Toast\Concerns\WireToast;

class CostUpdatedNotification
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
    public function handle(CostUpdated $event)
    {
        toast()->success('Speichervorgang erfolgreich', 'Achtung')->push();
    }
}

<?php

namespace App\Providers;

use App\Events;
use App\Events\CostUpdated;
use App\Events\CostAmountAdded;
use App\Events\CostAmountDeleted;
use App\Events\CostAmountUpdated;
use App\Events\VerbrauchsinfoUserEmailAdded;
use App\Events\VerbrauchsinfoUserEmailDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;

use App\Listeners;
use App\Listeners\CostUpdatedNotification;
use App\Listeners\CostAmountAddedNotification;
use App\Listeners\CostAmountDeletedNotification;
use App\Listeners\CostAmountUpdatedNotification;
use App\Listeners\VerbrauchsinfoUserEmailAddedListner;
use App\Listeners\VerbrauchsinfoUserEmailNotification;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CostUpdated::class => [
            CostUpdatedNotification::class,
        ],
        CostAmountAdded::class => [
            CostAmountAddedNotification::class,
        ],
        CostAmountDeleted::class => [
            CostAmountDeletedNotification::class,
        ],
        CostAmountUpdated::class => [
            CostAmountUpdatedNotification::class,
        ],

        VerbrauchsinfoUserEmailAdded::class => [
            VerbrauchsinfoUserEmailAddedListner::class,
        ],

        
     /*    VerbrauchsinfoUserEmailAdded::class => [
            VerbrauchsinfoUserEmailAddedNotification::class,
        ], */

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        /* Event::listen( 
            VerbrauchsinfoUserEmailAdded::class,
            [VerbrauchsinfoUserEmailNotification::class, 'created']
        ); */

      /*   Event::listen( 
            VerbrauchsinfoUserEmailDeleted::class,
            [VerbrauchsinfoUserEmailNotification::class, 'deleted']
        ); */

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

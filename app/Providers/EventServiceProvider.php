<?php

namespace App\Providers;

use App\Models\BillingAccount;
use App\Models\BillingApplication;
use App\Models\Contact;
use App\Models\Contact_Control;
use App\Models\User;
use App\Observers\BillingAccountObserver;
use App\Observers\BillingApplicationObserver;
use App\Observers\ContactObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        User::observe(UserObserver::class);
        Contact::observe(ContactObserver::class);
        BillingAccount::observe(BillingAccountObserver::class);
        BillingApplication::observe(BillingApplicationObserver::class);
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

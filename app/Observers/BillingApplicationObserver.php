<?php

namespace App\Observers;

use App\Models\BillingApplication;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BillingApplicationObserver
{
    /**
     * Handle the BillingApplication "created" event.
     *
     * @param  \App\Models\BillingApplication  $billingApplication
     * @return void
     */
    public function created(BillingApplication $billingApplication)
    {
        if (!$billingApplication->sender == Auth::id()) {
            Notification::create([
                'u_id' => $billingApplication->billingAccount->u_id,
                'type' => '1',
                'route' => route('myProfile'),
                'message' => 'You have a new message for your billing account.'
            ]);
        }
    }

    /**
     * Handle the BillingApplication "updated" event.
     *
     * @param  \App\Models\BillingApplication  $billingApplication
     * @return void
     */
    public function updated(BillingApplication $billingApplication)
    {
        //
    }

    /**
     * Handle the BillingApplication "deleted" event.
     *
     * @param  \App\Models\BillingApplication  $billingApplication
     * @return void
     */
    public function deleted(BillingApplication $billingApplication)
    {
        //
    }

    /**
     * Handle the BillingApplication "restored" event.
     *
     * @param  \App\Models\BillingApplication  $billingApplication
     * @return void
     */
    public function restored(BillingApplication $billingApplication)
    {
        //
    }

    /**
     * Handle the BillingApplication "force deleted" event.
     *
     * @param  \App\Models\BillingApplication  $billingApplication
     * @return void
     */
    public function forceDeleted(BillingApplication $billingApplication)
    {
        //
    }
}

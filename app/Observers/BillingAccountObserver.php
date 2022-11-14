<?php

namespace App\Observers;

use App\Models\BillingAccount;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BillingAccountObserver
{
    /**
     * Handle the BillingAccount "created" event.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return void
     */
    public function created(BillingAccount $billingAccount)
    {
        //
    }

    /**
     * Handle the BillingAccount "updated" event.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return void
     */
    public function updated(BillingAccount $billingAccount)
    {
        if($billingAccount->wasChanged('verified') || $billingAccount->wasChanged('rejected')) {
             Notification::create([
                 'u_id' => $billingAccount->u_id,
                 'type' => '1',
                 'route' => route('myProfile'),
                 'message' => 'Your billing account was changed status.'
             ]);
        }
        if($billingAccount->wasChanged('destroy') && !$billingAccount->u_id == Auth::id())
        {
            Notification::create([
                'u_id' => $billingAccount->u_id,
                'type' => '1',
                'route' => route('myProfile'),
                'message' => 'Your billing account was deleted.'
            ]);
        }
    }

    /**
     * Handle the BillingAccount "deleted" event.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return void
     */
    public function deleted(BillingAccount $billingAccount)
    {
        //
    }

    /**
     * Handle the BillingAccount "restored" event.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return void
     */
    public function restored(BillingAccount $billingAccount)
    {
        //
    }

    /**
     * Handle the BillingAccount "force deleted" event.
     *
     * @param  \App\Models\BillingAccount  $billingAccount
     * @return void
     */
    public function forceDeleted(BillingAccount $billingAccount)
    {
        //
    }
}

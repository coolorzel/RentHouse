<?php

namespace App\Observers;

use App\Models\Contact;
use App\Models\Contact_Control;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        Contact_Control::create([
            'information' => __('Created and sent new message.'),
            'message_id' => $contact->id,
        ]);
    }

    /**
     * Handle the Contact "updated" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        $information = '';
        $user = User::find(Auth::id())->first();
        if($contact->wasChanged('displayed')) {
            if ($contact->displayed == true) {
                $information = __('Has been marked as read');
            }else{
                $information = __('Has been marked as unread');
            }
        }

        if($contact->wasChanged('closed')) {
            if ($contact->closed == true) {
                $information = __('Has been marked as closed');
            }else{
                $information = __('Has been marked as unclosed');
            }
        }
        Contact_Control::create([
            'information' => $information,
            'message_id' => $contact->id,
            'viewer_u_id' => $user->id,
        ]);
    }

    /**
     * Handle the Contact "deleted" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function forceDeleted(Contact $contact)
    {
        //
    }
}

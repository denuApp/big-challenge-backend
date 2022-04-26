<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\PrescriptionUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationOfPrescription implements ShouldQueue
{
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
     * @param  \App\Providers\Diagnosed  $event
     * @return void
     */
    public function handle(Diagnosed $event)
    {
        $user = User::find($event->submission->patient_id);

        $user->notify(new PrescriptionUploaded($event->submission));
    }
}

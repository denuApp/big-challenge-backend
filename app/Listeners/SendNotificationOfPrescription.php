<?php

namespace App\Listeners;

use App\Events\Diagnosed;
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
     * @param  \App\Events\Diagnosed  $event
     * @return void
     */
    public function handle(Diagnosed $event)
    {
        $user = User::find($event->submission->patient_id);

        $user->notify(new PrescriptionUploaded($event->submission));
    }
}

<?php

namespace Httpfactory\Approvals\Listeners;

use Httpfactory\Approvals\Events\ApprovalRequest as ApprovalRequestEvent;

use Illuminate\Support\Facades\Mail;
use Httpfactory\Approvals\Mail\ApprovalRequest as ApprovalRequestEmail;

class ApprovalRequest
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
     * Handle the event
     *
     * @param ApprovalRequestEvent $event
     * @return void
     */
    public function handle(ApprovalRequestEvent $event)
    {
        //get the approval object from the event....
        $approval = $event->approval;
        $currentLevel = $event->approval->currentLevel;

        //here we should probably shoot an email to each user that needs to approve

        //this is just an example listener because whoever uses this package should be able
        //to add their own listener for the events that we fire off.

        foreach( $currentLevel->users as $user ) {
            Mail::to($user->email)->send(new ApprovalRequestEmail($approval, $user));
        }

    }

}

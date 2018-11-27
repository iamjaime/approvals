<?php

namespace Httpfactory\Approvals\Listeners;

use Httpfactory\Approvals\Events\ApprovalRequest as ApprovalRequestEvent;
use Httpfactory\Approvals\Models\Approval;

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
        $needApprovalBy = $event->approval->from; //the users that we are requesting approval from

        //here we should probably shoot an email to each user that needs to approve

        //this is just an example listener because whoever uses this package should be able
        //to add their own listener for the events that we fire off.

        foreach( $needApprovalBy as $approver ) {
            Mail::to($approver->email)->send(new ApprovalRequestEmail($approval, $approver));
        }

    }

}

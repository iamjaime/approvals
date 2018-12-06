<?php

namespace Httpfactory\Approvals\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Httpfactory\Approvals\Models\Approval;

class ApprovalDeclined
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //get the approval object from the event....
        $approval = $event->approval;

        //we should be able to grab the requester's user instance like so
        $requester = $approval->requester;
        $decliner = $event->declinedBy; //the user that declined the approval

        //here we should probably shoot an email to the requester of the approval
        //this is just an example listener because whoever uses this package should be able
        //to add their own listener for the events that we fire off.
    }
}

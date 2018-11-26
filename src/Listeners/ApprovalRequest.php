<?php

namespace Httpfactory\Approvals\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Httpfactory\Approvals\Models\Approval;

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
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //get the approval object from the event....
        $approval = $event->approval;
        $needApprovalBy = $event->users; //the users that we are requesting approval from

        //here we should probably shoot an email to each user that needs to approve

        //this is just an example listener because whoever uses this package should be able
        //to add their own listener for the events that we fire off.
    }
}

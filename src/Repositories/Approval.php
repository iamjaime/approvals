<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;


abstract class Approval implements Approvable {

    public $title;

    public $description;

    public $from;

    public $approvalsNeeded = 1; //by default


    /**
     * The user(s) we are requesting approval from
     * @param $approvers  array  The approver(s)
     * @return $this
     */
    public function from($approvers)
    {
        $this->from = $approvers;
        return $this;
    }

    /**
     * Sends the Approval Request
     */
    public function sendRequest()
    {
        //fires an event
        //event(new ApprovalRequest($this->approval));
    }


    /**
     * Handles approving the approval request
     * @param $request
     */
    public function approve($request)
    {
        //The user should have clicked on the email call to action button and
        //that will trigger this method.
        //at this point, we will query the database and update the record to approved

        //then fire off some event which indicates approval
        //event(new ApprovalApproved($approvedBy))


        //return approval logic
    }

    /**
     * Handles denying the approval request
     * @param $request
     */
    public function deny($request)
    {
        //The user should have clicked on the email call to action button and
        //that will trigger this method.
        //at this point, we will query the database and update the record to "denied"

        //then fire off some event which indicates approval denied
        //event(new ApprovalDenied($deniedBy))
    }

}
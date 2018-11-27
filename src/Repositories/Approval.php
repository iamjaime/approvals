<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;
use Httpfactory\Approvals\Events\ApprovalRequest;
use Illuminate\Contracts\Auth\Authenticatable as ApprovalRequester;

abstract class Approval implements Approvable {

    /**
     * Approval object title
     * @var
     */
    public $title;

    /**
     * Approval object description
     * @var
     */
    public $description;

    /**
     * Array of user instances that we require approval from
     * @var
     */
    public $from;

    /**
     * Number of approvals needed
     * @var int
     */
    public $approvalsNeeded = 1; //by default

    /**
     * The User Instance that is requesting the approval
     * @var ApprovalRequester
     */
    public $requester;


    public function __construct(ApprovalRequester $requester)
    {
        $this->requester = $requester;
    }


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
        event(new ApprovalRequest($this));
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
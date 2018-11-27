<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;
use Httpfactory\Approvals\Events\ApprovalRequest;
use Httpfactory\Approvals\Models\Approval as ApprovalRecord;
use Httpfactory\Approvals\Models\Approver;
use Illuminate\Contracts\Auth\Authenticatable as ApprovalRequester;

abstract class Approval implements Approvable {

    /**
     * Approval object id
     * @var
     */
    protected $id;

    /**
     * Approval object name
     * @var
     */
    public $name;

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

    /**
     * The approval token
     * @var
     */
    public $token;


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
        $approval = $this->saveApproval();
        $this->id = $approval->id;

        $this->saveApprovers();

        //fires an event
        event(new ApprovalRequest($this));
    }


    /**
     * Handles saving the approval object
     */
    protected function saveApproval()
    {
        $approval = new ApprovalRecord();
        $approval->name = $this->name;
        $approval->description = $this->description;
        $approval->save();

        return $approval;
    }

    /**
     * Handles saving the approvers
     */
    protected function saveApprovers()
    {
        foreach($this->from as $approver){
            $approverRecord = new Approver();
            $approverRecord->approval_id = $this->id;
            $approverRecord->approver_id = $approver->id;
            $approverRecord->status = 'pending';
            $approverRecord->save();
        }
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
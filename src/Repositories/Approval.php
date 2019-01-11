<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;
use Httpfactory\Approvals\Events\ApprovalRequest;
use Httpfactory\Approvals\Models\ApprovalRequest as ApprovalRecord;
use Httpfactory\Approvals\Models\ApprovalLevelRequest as Approver;
use Illuminate\Contracts\Auth\Authenticatable as ApprovalRequester;

abstract class Approval implements Approvable {

    /**
     * Approval object id
     * @var
     */
    protected $id;

    /**
     * The approval process id
     * @var
     */
    public $approval_process_id;

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
     * The Team Id that is requesting the approval
     * @var
     */
    public $team_id = null;

    /**
     * The approver records
     * @var
     */
    public $approvers = [];



    public function __construct(ApprovalRequester $requester)
    {
        $this->requester = $requester;

        if(!is_null($this->requester->currentTeam)){
            $this->team_id = $this->requester->currentTeam->id;
        }
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
        $this->approvers = $this->saveApprovers();

        //fires an event
        event(new ApprovalRequest($this));
    }


    /**
     * Handles saving the approval object
     */
    protected function saveApproval()
    {
        $approval = new ApprovalRecord();
        $approval->requester_id = $this->requester->id;
        $approval->approval_process_id = $this->approval_process_id;

        if(!is_null($this->team_id)){
            $approval->team_id = $this->team_id;
        }

        $approval->save();

        return $approval;
    }


    /**
     * Handles saving the approvers
     * @return array
     */
    protected function saveApprovers()
    {
        $approvers = [];

        foreach($this->from as $approver){

            $approverRecord = new Approver();
            $approverRecord->approval_element_id = $this->id;
            $approverRecord->approval_level_id = $this->id;
            $approverRecord->approver_level_user_id = $approver->id;
            $approverRecord->status = 'pending';
            $approverRecord->token = str_random(60);
            $approverRecord->save();

            $approverRecord->email = $approver->email;

            array_push($approvers, $approverRecord);
        }

        return $approvers;
    }

}
<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;
use Httpfactory\Approvals\Events\ApprovalRequest;
use Httpfactory\Approvals\Models\Approval as ApprovalRecord;
use Httpfactory\Approvals\Models\Approver;
use Httpfactory\Approvals\Models\ApprovalConfiguration;
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
        if(!is_null($this->team_id)){
            $approval->team_id = $this->team_id;
        }
        $approval->name = $this->name;
        $approval->description = $this->description;
        $approval->save();

        $this->saveConfiguration($approval);

        return $approval;
    }

    /**
     * Handles saving the default approval configurations
     */
    protected function saveConfiguration($approval)
    {
       $config = new ApprovalConfiguration();
       $config->approval_id = $approval->id;
       $config->save();

       $approval->approval_configuration_id = $config->id;
       $approval->save();
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
            $approverRecord->approval_id = $this->id;
            $approverRecord->approver_id = $approver->id;
            $approverRecord->status = 'pending';
            $approverRecord->token = str_random(60);
            $approverRecord->save();

            $approverRecord->email = $approver->email;

            array_push($approvers, $approverRecord);
        }

        return $approvers;
    }

}
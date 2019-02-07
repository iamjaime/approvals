<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;
use Httpfactory\Approvals\Events\ApprovalRequest;
use Httpfactory\Approvals\Models\ApprovalRequest as ApprovalRecord;
use Httpfactory\Approvals\Models\ApprovalLevelRequest;
use Httpfactory\Approvals\Models\ApprovalProcess;
use Httpfactory\Approvals\Models\ApprovalLevel;
use Httpfactory\Approvals\Models\User;

use Illuminate\Contracts\Auth\Authenticatable as ApprovalRequester;

abstract class Approval implements Approvable {

    /**
     * @var ApprovalRequester
     */
    public $requester;

    /**
     * @var ApprovalProcess
     */
    public $approvalProcess;

    /**
     * @var Team
     */
    public $team;

    /**
     * The levels associated with this approval.
     *
     * @var array of \Httpfactory\Approvals\Models\AppprovalLevel Objects
     */
    public $levels;

    /**
     * The approval request object
     *
     * @var \Httpfactory\Approvals\Models\ApprovalRequest
     */
    public $approvalRequest;

    /**
     * The current assessment level with users associated to it.
     *
     * @var \Httpfactory\Approvals\Models\ApprovalLevel
     */
    public $currentLevel;


    public function __construct(ApprovalRequester $requester, ApprovalProcess $approvalProcess, ApprovalRecord $approvalRequest = null)
    {
        $this->requester = $requester;
        $this->approvalProcess = $approvalProcess;
        $this->levels = $this->approvalProcess->approvalElement->levels;

        if(!is_null($approvalRequest)){
            $this->approvalRequest = $approvalRequest;
        }

        if(!is_null($this->requester->currentTeam)){
            $this->team = $this->requester->currentTeam;
        }

        $this->getLevelUsers();
    }

    /**
     * Sends the Approval Request to the initial level
     */
    public function sendRequest($attachments = null)
    {
        if(!$this->approvalRequest) {
            $this->saveApprovalRequest($attachments);
        }

        $this->getCurrentAssessmentApprovalLevel();
        $this->saveApprovalLevelRequest();

        //fires an event
        event(new ApprovalRequest($this));
    }


    /**
     * Handles getting the level user ids and converting them into
     * User objects
     */
    private function getLevelUsers()
    {
        $userIds = [];
        foreach($this->levels as $level){

            foreach($level->users as $user){
                array_push($userIds, $user->user_id);
            }

            $users = User::whereIn('id', $userIds)->get();
            $level->users = $users;
            $userIds = [];
        }

    }


    /**
     * Handles saving the approval request
     */
    protected function saveApprovalRequest($attachments = null)
    {
        $approvalRequest = new ApprovalRecord();
        $approvalRequest->team_id = $this->team->id;
        $approvalRequest->requester_id = $this->requester->id;
        $approvalRequest->approval_process_id = $this->approvalProcess->id;
        $approvalRequest->current_assessment_level_id = $this->levels[0]->id; //initial level
        $approvalRequest->status = "pending";
        $approvalRequest->save();

        if(!is_null($attachments)){
            $approvalRequest->documents()->saveMany($attachments);
        }

        $this->approvalRequest = $approvalRequest;
    }


    /**
     * Handles getting the current approval level with users
     */
    private function getCurrentAssessmentApprovalLevel()
    {
        $userIds = [];
        $currentLevel = ApprovalLevel::where('id', $this->approvalRequest->current_assessment_level_id)->with('users')->first();
        foreach($currentLevel->users as $user){
            array_push($userIds, $user->user_id);
        }

        $users = User::whereIn('id', $userIds)->get();

        $this->currentLevel = $currentLevel;
        $this->currentLevel->users = $users;
    }


    /**
     * Handles saving the current level approval level request
     */
    protected function saveApprovalLevelRequest()
    {
        foreach($this->currentLevel->users as $user){

            $approvalLevelRequest = new ApprovalLevelRequest();
            $approvalLevelRequest->team_id = $this->team->id;

            $approvalLevelRequest->approval_request_id = $this->approvalRequest->id;
            $approvalLevelRequest->approval_process_id = $this->approvalProcess->id;
            $approvalLevelRequest->approval_element_id = $this->approvalProcess->approvalElement->id;
            $approvalLevelRequest->approval_level_id = $this->currentLevel->id;
            $approvalLevelRequest->user_id = $user->id;
            $approvalLevelRequest->status = "pending";
            $approvalLevelRequest->token = str_random(16);
            $approvalLevelRequest->save();

            //now lets attach this new "approval level request" object to the user object....
            $user->approval_level_request = $approvalLevelRequest;
        }

    }

}
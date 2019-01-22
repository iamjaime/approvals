<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Contracts\Approvable;
use Httpfactory\Approvals\Events\ApprovalRequest;
use Httpfactory\Approvals\Models\ApprovalRequest as ApprovalRecord;
use Httpfactory\Approvals\Models\ApprovalLevelRequest as Approver;
use Httpfactory\Approvals\Models\ApprovalProcess;
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


    public function __construct(ApprovalRequester $requester, ApprovalProcess $approvalProcess)
    {
        $this->requester = $requester;
        $this->approvalProcess = $approvalProcess;
        $this->levels = $this->approvalProcess->approvalElement->levels;

        if(!is_null($this->requester->currentTeam)){
            $this->team = $this->requester->currentTeam;
        }

        $this->getLevelUsers();
        dd($this);
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


}
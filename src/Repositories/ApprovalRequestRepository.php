<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Events\ApprovalAwarded;
use Httpfactory\Approvals\Listeners\ApprovalDenied;
use Httpfactory\Approvals\Models\ApprovalLevelRequest as Approver;
use Httpfactory\Approvals\Models\ApprovalLevel;
use Httpfactory\Approvals\Models\User;
use Httpfactory\Approvals\Models\ApprovalRequest as Approval;
use Httpfactory\Approvals\Contracts\ApprovalRequestRepository as ApprovalRepositoryInterface;
use Httpfactory\Approvals\Events\ApprovalApproved;
use Httpfactory\Approvals\Events\ApprovalDeclined;
use Httpfactory\Approvals\ApprovalProcess;
use Httpfactory\Approvals\ApprovalRequest as AR;
use Illuminate\Support\Facades\Auth;


class ApprovalRequestRepository implements ApprovalRepositoryInterface
{
    /**
     * @var \Httpfactory\Approvals\Models\ApprovalProcess The approval process
     */
    public $process;

    /**
     * @var array The levels for this request
     */
    public $levels;

    /**
     * @var array The levels that have already completed their actions
     */
    public $completedLevels = [];

    /**
     * Handles approving the Approval Request.
     *
     * @param $token
     * @return mixed
     */
    public function approve($token)
    {
        //The user should have clicked on the email call to action button and
        //that will trigger this method.
        //at this point, we will query the database and update the record to approved
        $approvalRecord = Approver::where('token', '=', $token)->first();
        $approvalRecord->status = 'approved';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //then fire off some event which indicates approval approved
        $approvedBy = User::where('id', $approvalRecord->user_id)->first();

        event(new ApprovalApproved($approvalRecord, $approvedBy));

        $this->setApprovalProcessLevels($approvalRecord->approval_process_id);
        $this->finalizeApproval($approvalRecord);

        return $approvalRecord;
    }

    /**
     * Handles declining the Approval Request.
     *
     * @param $token
     * @return mixed
     */
    public function decline($token)
    {
        $approvalRecord = Approver::where('token', '=', $token)->first();
        $approvalRecord->status = 'declined';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //then fire off some event which indicates approval declined
        $approval = $approvalRecord;
        $declinedBy = User::where('id', $approvalRecord->user_id)->first();;

        event(new ApprovalDeclined($approval, $declinedBy));

        $this->finalizeApproval($approvalRecord);

        return $approvalRecord;
    }


    /**
     * Checks if the token is valid
     *
     * @param $token
     * @return bool
     */
    public function tokenValid($token)
    {
        $approvalRecord = Approver::where('token', '=', $token)->first();
        if($approvalRecord){
            return true;
        }
        return false;
    }


    /**
     * Handle awarding the approval request
     * @param $approval
     */
    protected function award($approval)
    {
        $approvalRecord = Approval::where('id', '=', $approval->approval_request_id)->first();
        $approvalRecord->status = 'awarded';
        $approvalRecord->save();

        event(new ApprovalAwarded($approval));
    }

    /**
     * Handle denying the approval request
     * @param $approval
     */
    protected function denied($approval)
    {
        $approvalRecord = Approval::where('id', '=', $approval->approval_request_id)->first();
        $approvalRecord->status = 'denied';
        $approvalRecord->save();

        event(new ApprovalDenied($approval));
    }


    /**
     * Handles finalizing the approval request
     *
     * @param $approval
     */
    protected function finalizeApproval($approval)
    {
        $config = ApprovalLevel::where('id', $approval->approval_level_id)->first();

        $approvedRecords = Approver::where('approval_request_id', '=', $approval->approval_request_id)->where('status', '=', 'approved')->count();
        $declinedRecords = Approver::where('approval_request_id', '=', $approval->approval_request_id)->where('status', '=', 'declined')->count();

        //dd(['approved_records' => $approvedRecords, 'declined_records' => $declinedRecords, 'required_yes_count' => $config->required_yes_count, 'required_no_count' => $config->required_no_count]);

        if( $approvedRecords >= $config->required_yes_count){

            $completeLevel = $this->levelComplete($approval);
            $nextLevel = $this->getNextLevel();

            if(!$nextLevel){
                $this->award($approval);
            }else{
                //we have another level to take care of....
                $approvalRequest = Approval::where('id', $approval->approval_request_id)->first();
                $approvalRequest->current_assessment_level_id = $nextLevel['id'];
                $approvalRequest->save();

                $ar = new AR(Auth::user(), $this->process, $approvalRequest);
                $ar->sendRequest();
            }

        }elseif( $declinedRecords >= $config->required_no_count ){


            $this->denied($approval);

        }

    }


    /**
     * Handles completing a level
     *
     * @param $approval
     */
    protected function levelComplete($approval)
    {
        //lets update the approval_request table .....
        $approvalRequest = Approval::where('id', $approval->approval_request_id)->first();
        $completedLevels = [];

        if($approvalRequest->completed_assessment_levels) {
            $completedLevels = json_decode($approvalRequest->completed_assessment_levels);
        }else{
            array_push($completedLevels, $approval->approval_level_id);
        }

        $approvalRequest->completed_assessment_levels = json_encode($completedLevels);
        $approvalRequest->save();

        $this->completedLevels = $completedLevels;
    }


    /**
     * Sets the approval levels as a global variable
     *
     * @param $processId
     * @return mixed
     */
    private function setApprovalProcessLevels($processId)
    {
        $approvalProcess = new ApprovalProcess();
        $process = $approvalProcess->getById($processId);

        $this->process = $process;
        $this->levels = $process->approvalElement->levels->toArray();

        return $process;
    }


    /**
     * Gets the next level in the chain OR returns false if no more levels
     *
     * @return bool|mixed
     */
    protected function getNextLevel()
    {
       $count = -1;
       foreach($this->levels as $level){
           $count++;
           if(in_array($level['id'], $this->completedLevels)){
               unset($this->levels[$count]);
           }
       }
       $this->levels = array_values($this->levels);

       if(count($this->levels)){
           return $this->levels[0];
       }else{
           return false;
       }
    }

}
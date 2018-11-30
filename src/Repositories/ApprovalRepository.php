<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Events\ApprovalAwarded;
use Httpfactory\Approvals\Listeners\ApprovalDenied;
use Httpfactory\Approvals\Models\Approver;
use Httpfactory\Approvals\Models\Approval;
use Httpfactory\Approvals\Contracts\ApprovalRepository as ApprovalRepositoryInterface;
use Httpfactory\Approvals\Events\ApprovalApproved;
use Httpfactory\Approvals\Events\ApprovalDeclined;

class ApprovalRepository implements ApprovalRepositoryInterface
{

    /**
     * Handles approving the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function approve($token)
    {
        //The user should have clicked on the email call to action button and
        //that will trigger this method.
        //at this point, we will query the database and update the record to approved
        $approvalRecord = Approver::where('token', '=', $token)->with(['approval.configuration', 'approver'])->first();
        $approvalRecord->status = 'approved';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //then fire off some event which indicates approval approved
        $approvedBy = $approvalRecord->approver;
        event(new ApprovalApproved($approvedBy));

        $this->finalizeApproval($approvalRecord);

        return $approvalRecord;
    }

    /**
     * Handles declining the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function decline($token)
    {
        $approvalRecord = Approver::where('token', '=', $token)->with(['approval.configuration', 'approver'])->first();
        $approvalRecord->status = 'declined';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //then fire off some event which indicates approval declined
        $approval = $approvalRecord->approval;
        $declinedBy = $approvalRecord->approver;

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
     * Handle awarding the approval
     * @param $approval
     */
    protected function award($approval)
    {
        $approvalRecord = Approval::where('id', '=', $approval->id)->first();
        $approvalRecord->status = 'awarded';
        $approvalRecord->save();

        event(new ApprovalAwarded($approval));
    }

    /**
     * Handle denying the approval
     * @param $approval
     */
    protected function denied($approval)
    {
        $approvalRecord = Approval::where('id', '=', $approval->id)->first();
        $approvalRecord->status = 'denied';
        $approvalRecord->save();

        event(new ApprovalDenied($approval));
    }


    /**
     * Handles finalizing the approval
     *
     * @param $approval
     */
    protected function finalizeApproval($approval)
    {
       $config = $approval->configuration();
       $approvedRecords = Approver::where('approval_id', '=', $approval->id)->where('status', '=', 'approved')->count();
       $declinedRecords = Approver::where('approval_id', '=', $approval->id)->where('status', '=', 'declined')->count();

       if( $config->yes >= $approvedRecords ){
           $this->award($approval);
       }elseif( $config->no >= $declinedRecords ){
           $this->denied($approval);
       }

    }
}
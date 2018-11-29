<?php

namespace Httpfactory\Approvals\Repositories;

use Httpfactory\Approvals\Models\Approver;
use Httpfactory\Approvals\Contracts\ApprovalRepository as ApprovalRepositoryInterface;
use Httpfactory\Approvals\Events\ApprovalApproved;
use Httpfactory\Approvals\Events\ApprovalDenied;

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
        $approvalRecord = Approver::where('token', '=', $token)->with(['approval', 'approver'])->first();
        $approvalRecord->status = 'approved';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //then fire off some event which indicates approval approved
        $approvedBy = $approvalRecord->approver;
        event(new ApprovalApproved($approvedBy));

        return $approvalRecord;
    }

    /**
     * Handles denying the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function deny($token)
    {
        $approvalRecord = Approver::where('token', '=', $token)->with(['approval', 'approver'])->first();
        $approvalRecord->status = 'denied';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //then fire off some event which indicates approval denied
        $deniedBy = $approvalRecord->approver;
        event(new ApprovalDenied($deniedBy));

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
}

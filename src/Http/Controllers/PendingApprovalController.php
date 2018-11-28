<?php

namespace Httpfactory\Approvals\Http\Controllers;

use Httpfactory\Approvals\Models\Approval;

class PendingApprovalController extends Controller
{

    /**
     * Handles approving the Approval.
     *
     * @param $token
     */
    public function approve($token)
    {
        $approvalRecord = Approval::where('token', '=', $token)->first();
        abort_unless($approvalRecord, 404);
        $approvalRecord->status = 'approved';
        $approvalRecord->save();

        //now we should redirect somewhere...
    }

    /**
     * Handles denying the Approval.
     *
     * @param $token
     */
    public function deny($token)
    {
        $approvalRecord = Approval::where('token', '=', $token)->first();
        abort_unless($approvalRecord, 404);
        $approvalRecord->status = 'denied';
        $approvalRecord->save();

        //now we should redirect somewhere...
    }
}

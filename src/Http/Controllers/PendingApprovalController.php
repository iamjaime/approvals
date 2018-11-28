<?php

namespace Httpfactory\Approvals\Http\Controllers;

use Httpfactory\Approvals\Models\Approver;

class PendingApprovalController extends Controller
{

    /**
     * Handles approving the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function approve($token)
    {
        $approvalRecord = Approver::where('token', '=', $token)->first();
        abort_unless($approvalRecord, 404);
        $approvalRecord->status = 'approved';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //now we should redirect somewhere...
        return view('approvals::approvals.approve');
    }

    /**
     * Handles denying the Approval.
     *
     * @param $token
     * @return mixed
     */
    public function deny($token)
    {
        $approvalRecord = Approver::where('token', '=', $token)->first();
        abort_unless($approvalRecord, 404);
        $approvalRecord->status = 'denied';
        $approvalRecord->token = '';
        $approvalRecord->save();

        //now we should redirect somewhere...
        return view('approvals::approvals.denied');
    }
}
